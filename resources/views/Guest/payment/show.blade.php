@extends('Guest.main')

@section('content')
<div class="container" style="margin-top: 80px">
    <h2>Detail Pembayaran</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card mt-3">
        <div class="card-body">
            <h4>Customer: {{ $order->reservator_name }}</h4>
            <p>Tanggal: {{ $order->created_at->format('d M Y H:i') }}</p>
            <p>Status: 
                @if($order->payment_status === 'paid')
                    <span class="badge badge-success">Lunas</span>
                @else
                    <span class="badge badge-warning">Belum Dibayar</span>
                    <span class="badge badge-danger">
                        Silakan bayar dikasir terlebih dahulu!
                    </span>
                @endif
            </p>

            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>Menu</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->details as $detail)
                        <tr>
                            <td>{{ $detail->menu->menu_name ?? 'Menu' }}</td>
                            <td>{{ $detail->quantity }}</td>
                            <td>Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-right">Total</th>
                        <th>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</th>
                    </tr>
                </tfoot>
            </table>
            @if($order->status === 'approved')                
                <span class="badge badge-success">Pesanan sedang diproses, mohon tunggu sebentar.</span>
            @elseif($order->status === 'rejected')                
                <span class="badge badge-danger">Pesanan ditangguhkan.</span>
            @elseif($order->status === 'served')
                <a href="{{ url('/') }}" class="btn btn-success">Selesai</a>
            @endif
        </div>
    </div>
</div>
@endsection
