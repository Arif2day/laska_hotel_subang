@if(session('cart'))
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Menu</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Total</th>
                <th>Catatan</th>
                <th></th>
            </tr>
            </thead>
        <tbody>
            @php $grandTotal = 0; @endphp
            @foreach(session('cart') as $id => $item)
                @php $total = $item['price'] * $item['qty']; $grandTotal += $total; @endphp
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['qty'] }}</td>
                    <td>Rp {{ number_format($item['price'],0,',','.') }}</td>
                    <td>Rp {{ number_format($total,0,',','.') }}</td>
                    <td>
                        <input type="text" class="form-control update-note" 
                               data-id="{{ $id }}" 
                               value="{{ $item['note'] ?? '' }}" 
                               placeholder="Catatan (opsional)">
                    </td>
                    <td>
                        <button class="btn btn-danger btn-sm remove-from-cart" data-id="{{ $id }}">Hapus</button>
                    </td>
                </tr>
            @endforeach
            <tr><th colspan="3">Grand Total</th><th>Rp {{ number_format($grandTotal,0,',','.') }}</th><th></th><th></th></tr>
        </tbody>
    </table>
    @if(session('cart') && count(session('cart')) > 0)
        <div class="mt-3">
            <label for="customer_name">Nama Pemesan</label>
            <input type="text" id="customer_name" class="form-control" placeholder="Masukkan nama Anda">
        </div>
        
        <div class="text-right mt-3">
            <button id="checkout-btn" class="btn btn-primary">
                <i class="bx bx-check-circle"></i> Checkout
            </button>
        </div>
    @endif
</div>

@else
<p>Keranjang masih kosong.</p>
@endif
