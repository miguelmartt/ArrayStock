<x-app-layout>
    <x-slot name="header">Dashboard</x-slot>

    <!-- KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <!-- Total Products -->
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Productos</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalProducts }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Inventory Value -->
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Valor del Inventario</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($inventoryValue, 2, ',', '.') }} &euro;</p>
                </div>
                <div class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Low Stock -->
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Stock Bajo</p>
                    <p class="text-2xl font-bold {{ $lowStockCount > 0 ? 'text-red-600' : 'text-gray-800' }} mt-1">{{ $lowStockCount }}</p>
                </div>
                <div class="w-12 h-12 {{ $lowStockCount > 0 ? 'bg-red-50' : 'bg-gray-50' }} rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 {{ $lowStockCount > 0 ? 'text-red-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.832c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Today Movements -->
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Movimientos Hoy</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $todayMovements }}</p>
                </div>
                <div class="w-12 h-12 bg-amber-50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Movements Chart -->
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h3 class="text-sm font-semibold text-gray-700 mb-4">Movimientos - Últimos 30 días</h3>
            <canvas id="movementsChart" height="200"></canvas>
        </div>

        <!-- Category Distribution -->
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h3 class="text-sm font-semibold text-gray-700 mb-4">Distribución por Categoría</h3>
            <canvas id="categoryChart" height="200"></canvas>
        </div>
    </div>

    <!-- Top Products Chart -->
    <div class="bg-white rounded-xl border border-gray-200 p-5 mb-6">
        <h3 class="text-sm font-semibold text-gray-700 mb-4">Top 10 Productos con más salidas (30 días)</h3>
        <canvas id="topProductsChart" height="120"></canvas>
    </div>

    <!-- Bottom Row: Low Stock + Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Low Stock Alert -->
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-semibold text-gray-700">Productos con Stock Bajo</h3>
                @if($lowStockProducts->isNotEmpty())
                    <span class="bg-red-100 text-red-700 text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $lowStockCount }} alertas</span>
                @endif
            </div>
            @if($lowStockProducts->isEmpty())
                <p class="text-sm text-gray-400 text-center py-8">Todos los productos tienen stock suficiente</p>
            @else
                <div class="space-y-3">
                    @foreach($lowStockProducts as $product)
                        <div class="flex items-center justify-between py-2 border-b border-gray-50 last:border-0">
                            <div class="flex items-center gap-3">
                                <div class="w-2 h-2 rounded-full" style="background-color: {{ $product->category->color ?? '#6B7280' }}"></div>
                                <div>
                                    <p class="text-sm font-medium text-gray-700">{{ $product->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $product->category->name ?? 'Sin categoría' }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-red-600">{{ $product->stock }} {{ $product->unit }}</p>
                                <p class="text-xs text-gray-400">Mín: {{ $product->min_stock }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Recent Activity -->
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h3 class="text-sm font-semibold text-gray-700 mb-4">Actividad Reciente</h3>
            @if($recentMovements->isEmpty())
                <p class="text-sm text-gray-400 text-center py-8">Sin movimientos registrados</p>
            @else
                <div class="space-y-3">
                    @foreach($recentMovements as $movement)
                        <div class="flex items-center justify-between py-2 border-b border-gray-50 last:border-0">
                            <div class="flex items-center gap-3">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                    {{ $movement->type === 'entry' ? 'bg-green-100 text-green-700' : '' }}
                                    {{ $movement->type === 'exit' ? 'bg-red-100 text-red-700' : '' }}
                                    {{ $movement->type === 'adjustment' ? 'bg-blue-100 text-blue-700' : '' }}">
                                    {{ $movement->type_label }}
                                </span>
                                <div>
                                    <p class="text-sm font-medium text-gray-700">{{ $movement->product->name ?? 'Eliminado' }}</p>
                                    <p class="text-xs text-gray-400">{{ $movement->user->name ?? 'Sistema' }} &middot; {{ $movement->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <span class="text-sm font-semibold {{ $movement->type === 'entry' ? 'text-green-600' : ($movement->type === 'exit' ? 'text-red-600' : 'text-blue-600') }}">
                                {{ $movement->type === 'entry' ? '+' : ($movement->type === 'exit' ? '-' : '') }}{{ $movement->quantity }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Movements Line Chart
            new Chart(document.getElementById('movementsChart'), {
                type: 'line',
                data: {
                    labels: @json($chartDates),
                    datasets: [
                        {
                            label: 'Entradas',
                            data: @json($chartEntries),
                            borderColor: '#22c55e',
                            backgroundColor: 'rgba(34, 197, 94, 0.1)',
                            tension: 0.3,
                            fill: true,
                        },
                        {
                            label: 'Salidas',
                            data: @json($chartExits),
                            borderColor: '#ef4444',
                            backgroundColor: 'rgba(239, 68, 68, 0.1)',
                            tension: 0.3,
                            fill: true,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { position: 'bottom' } },
                    scales: {
                        y: { beginAtZero: true, ticks: { stepSize: 1 } }
                    }
                }
            });

            // Category Doughnut Chart
            new Chart(document.getElementById('categoryChart'), {
                type: 'doughnut',
                data: {
                    labels: @json($categoryLabels),
                    datasets: [{
                        data: @json($categoryData),
                        backgroundColor: @json($categoryColors),
                        borderWidth: 2,
                        borderColor: '#fff',
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { position: 'bottom' } }
                }
            });

            // Top Products Bar Chart
            new Chart(document.getElementById('topProductsChart'), {
                type: 'bar',
                data: {
                    labels: @json($topProductLabels),
                    datasets: [{
                        label: 'Salidas',
                        data: @json($topProductData),
                        backgroundColor: '#f59e0b',
                        borderRadius: 6,
                    }]
                },
                options: {
                    responsive: true,
                    indexAxis: 'y',
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { beginAtZero: true, ticks: { stepSize: 1 } }
                    }
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
