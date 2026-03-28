<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; background: #f9fafb; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .header { background: #111827; color: #fff; padding: 24px; text-align: center; }
        .header h1 { margin: 0; font-size: 20px; }
        .header p { margin: 8px 0 0; color: #9ca3af; font-size: 14px; }
        .content { padding: 24px; }
        .alert-badge { display: inline-block; background: #fef2f2; color: #dc2626; padding: 4px 12px; border-radius: 20px; font-size: 13px; font-weight: 600; margin-bottom: 16px; }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; font-size: 12px; color: #6b7280; text-transform: uppercase; padding: 8px 12px; border-bottom: 2px solid #f3f4f6; }
        td { padding: 10px 12px; border-bottom: 1px solid #f3f4f6; font-size: 14px; color: #374151; }
        .stock-low { color: #dc2626; font-weight: 700; }
        .category { display: inline-block; background: #f3f4f6; padding: 2px 8px; border-radius: 10px; font-size: 12px; }
        .footer { padding: 16px 24px; background: #f9fafb; text-align: center; font-size: 12px; color: #9ca3af; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>ArrayStock - Inventario</h1>
            <p>Alerta de Stock Bajo</p>
        </div>
        <div class="content">
            <span class="alert-badge">{{ $products->count() }} producto(s) por debajo del mínimo</span>
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Categoría</th>
                        <th>Stock</th>
                        <th>Mínimo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td><strong>{{ $product->name }}</strong></td>
                        <td><span class="category">{{ $product->category->name ?? 'Sin categoría' }}</span></td>
                        <td class="stock-low">{{ $product->stock }} {{ $product->unit }}</td>
                        <td>{{ $product->min_stock }} {{ $product->unit }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="footer">
            <p>Este email fue generado automáticamente por el sistema de inventario de ArrayStock.</p>
            <p>{{ now()->format('d/m/Y H:i') }}</p>
        </div>
    </div>
</body>
</html>
