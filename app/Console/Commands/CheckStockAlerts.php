<?php

namespace App\Console\Commands;

use App\Mail\LowStockAlert;
use App\Models\Product;
use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

#[Signature('stock:check-alerts')]
#[Description('Revisa productos con stock bajo y envía alerta por email')]
class CheckStockAlerts extends Command
{
    public function handle(): int
    {
        $lowStockProducts = Product::with('category')
            ->where('active', true)
            ->whereColumn('stock', '<=', 'min_stock')
            ->orderBy('stock')
            ->get();

        if ($lowStockProducts->isEmpty()) {
            $this->info('Todos los productos tienen stock suficiente.');
            return self::SUCCESS;
        }

        $recipients = User::pluck('email')->toArray();

        if (empty($recipients)) {
            $this->warn('No hay usuarios registrados para enviar alertas.');
            return self::FAILURE;
        }

        Mail::to($recipients)->send(new LowStockAlert($lowStockProducts));

        $this->info("Alerta enviada: {$lowStockProducts->count()} productos con stock bajo.");
        return self::SUCCESS;
    }
}
