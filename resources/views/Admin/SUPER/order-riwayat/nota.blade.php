<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nota Order #{{ $order->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .nota { width: 280px; margin: 0 auto; }
        h4, p { margin: 2px 0; text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        td, th { padding: 4px; font-size: 12px; }
        .right { text-align: right; }
        .center { text-align: center; }
        hr { border: none; border-top: 1px dashed #000; margin: 5px 0; }
    </style>
</head>
<body onload="window.print()">
    <div class="nota">
        <h4>LASKA HOTEL SUBANG</h4>
        <p>Kompleks Ruko Rawabadak, Jl. Kapten Hanafiah, Karanganyar,
            Kec. Subang, Kabupaten Subang, Jawa Barat 41211</p>
        <hr>
        <p><strong>Nota Order</strong></p>
        <p>ID: {{ $order->id }} | {{ $order->created_at->format('d/m/Y H:i') }}</p>
        <p>Meja: {{ $order->table->table_name }}</p>
        <p>Reservator: {{ $order->reservator_name }}</p>
        <hr>
        <table>
            <thead>
                <tr>
                    <th>Menu</th>
                    <th class="center">Qty</th>
                    <th class="right">Harga</th>
                    <th class="right">Sub</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->details as $d)
                <tr>
                    <td>{{ $d->menu->menu_name }}</td>
                    <td class="center">{{ $d->quantity }}</td>
                    <td class="right">{{ number_format($d->price,0,',','.') }}</td>
                    <td class="right">{{ number_format($d->quantity * $d->price,0,',','.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <hr>
        <p class="right"><strong>Total: Rp {{ number_format($order->total_amount,0,',','.') }}</strong></p>
        <p class="center">Terima Kasih 🙏</p>
    </div>
</body>
</html>
