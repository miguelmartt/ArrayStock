<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\StockMovement;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // KPIs
        $totalProducts = Product::where('active', true)->count();
        $inventoryValue = Product::where('active', true)->selectRaw('SUM(stock * price) as total')->value('total') ?? 0;
        $lowStockCount = Product::where('active', true)->whereColumn('stock', '<=', 'min_stock')->count();
        $todayMovements = StockMovement::whereDate('created_at', today())->count();

        // Low stock products
        $lowStockProducts = Product::with('category')
            ->where('active', true)
            ->whereColumn('stock', '<=', 'min_stock')
            ->orderBy('stock')
            ->limit(10)
            ->get();

        // Recent movements
        $recentMovements = StockMovement::with(['product', 'user'])
            ->latest()
            ->limit(10)
            ->get();

        // Chart: Movements last 30 days
        $movementsChart = StockMovement::where('created_at', '>=', now()->subDays(30))
            ->selectRaw('DATE(created_at) as date, type, COUNT(*) as count')
            ->groupBy('date', 'type')
            ->orderBy('date')
            ->get()
            ->groupBy('date');

        $chartDates = [];
        $chartEntries = [];
        $chartExits = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $chartDates[] = now()->subDays($i)->format('d/m');
            $dayData = $movementsChart->get($date);
            $chartEntries[] = $dayData ? $dayData->where('type', 'entry')->sum('count') : 0;
            $chartExits[] = $dayData ? $dayData->where('type', 'exit')->sum('count') : 0;
        }

        // Chart: Distribution by category
        $categoryChart = Category::withCount(['products' => function ($q) {
            $q->where('active', true);
        }])->having('products_count', '>', 0)->get();

        $categoryLabels = $categoryChart->pluck('name')->toArray();
        $categoryData = $categoryChart->pluck('products_count')->toArray();
        $categoryColors = $categoryChart->pluck('color')->toArray();

        // Chart: Top 10 products with most exits
        $topProducts = Product::select('products.name', DB::raw('COALESCE(SUM(stock_movements.quantity), 0) as total_exits'))
            ->leftJoin('stock_movements', function ($join) {
                $join->on('products.id', '=', 'stock_movements.product_id')
                    ->where('stock_movements.type', '=', 'exit')
                    ->where('stock_movements.created_at', '>=', now()->subDays(30));
            })
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_exits')
            ->limit(10)
            ->get();

        $topProductLabels = $topProducts->pluck('name')->toArray();
        $topProductData = $topProducts->pluck('total_exits')->toArray();

        return view('dashboard', compact(
            'totalProducts', 'inventoryValue', 'lowStockCount', 'todayMovements',
            'lowStockProducts', 'recentMovements',
            'chartDates', 'chartEntries', 'chartExits',
            'categoryLabels', 'categoryData', 'categoryColors',
            'topProductLabels', 'topProductData'
        ));
    }
}
