@extends('Guest.main')

@section('content')
<main class="l-main">
    <!--========== MENU SECTION ==========-->
    <section class="menu section bd-container" id="menu">
        <h2 class="section-title">Menu Kami</h2>
        <p class="section-subtitle">Pilih menu favorit Anda dan masukkan ke keranjang</p>

        <div class="menu__container bd-grid">        
            @foreach($menus as $menu)            
            <div class="menu__content">
                <img src="{{ $menu['picture_path'] ?? asset('img/empty.jpg') }}" alt="{{ $menu['menu_name'] }}" class="menu__img">

                <h3 class="menu__name" style="margin-top: 170px;">{{ $menu['menu_name'] }}</h3>
                <span class="menu__detail">{{ $menu['description'] }}</span>
                <span class="menu__preci">Rp {{ number_format($menu['price'], 0, ',', '.') }}</span>

                <div class="menu__order" style="margin-top: 25px">
                    <input type="number" id="qty-{{ $menu['id'] }}" class="menu__qty" min="1" value="1">
                    <button class="btn btn-success text-center add-to-cart menu__button"
                        data-id="{{ $menu['id'] }}"
                        data-name="{{ $menu['menu_name'] }}"
                        data-price="{{ $menu['price'] }}">
                        <i class='bx bx-cart-alt'></i>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    <!--========== KERANJANG MODAL ==========-->
    <div class="modal fade" id="cartModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Keranjang Belanja</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" id="cart-content">
                    @include('Guest.menu.partials.cart')
                </div>
            </div>
        </div>
    </div>

    <!--========== TOMBOL LIHAT KERANJANG ==========-->
    <div class="cart-float cart-icon">
        <button class="btn btn-primary button--flex" data-toggle="modal" data-target="#cartModal">
            <i class="bx bx-cart"></i>
            <span id="cart-count">{{ session('cart') ? count(session('cart')) : 0 }}</span>
        </button>
    </div>
</main>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function(){

    // Tambah ke keranjang
    $('.add-to-cart').click(function(){
        let id = $(this).data('id');
        let name = $(this).data('name');
        let price = $(this).data('price');
        let qty = $('#qty-' + id).val();
        let qtyInput = $("#qty-" + id);

        $.post("{{ route('cart.add') }}", {
            _token: "{{ csrf_token() }}",
            id: id, name: name, price: price, qty: qty
        }, function(){
            refreshCart()
        }).then(()=>{
                qtyInput.val(1);
            });;        

            // efek shake pada icon
        let $cartIcon = $(".cart-icon");
        $cartIcon.addClass("shake");
        setTimeout(() => {
            $cartIcon.removeClass("shake");
        }, 400);
    });

    // Hapus dari keranjang
    $(document).on('click', '.remove-from-cart', function(){
        let id = $(this).data('id');
        $.post("{{ route('cart.remove') }}", {
            _token: "{{ csrf_token() }}",
            id: id
        }, function(){
            refreshCart();
        });
    });

    // Refresh isi keranjang & jumlah
    function refreshCart(){
        $('#cart-content').load("{{ route('cart.view') }}");
        $.get("{{ route('cart.view') }}", function(data){
            let count = $(data).find('tbody tr').length - 1; // minus grand total row
            if(count < 0) count = 0;
            $('#cart-count').text(count);
        });
    }

    // Update note langsung di modal
    $(document).on("change", ".update-note", function() {
        let id   = $(this).data("id");
        let note = $(this).val();

        $.ajax({
            url: "{{ route('cart.updateNote') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: id,
                note: note
            }
        });
    });

    $(document).on("click", "#checkout-btn", function(e) {
        e.preventDefault();

        let customerName = $("#customer_name").val();

        if(customerName.trim() === ""){
            Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "Nama pemesan harus diisi!",
            });
            return;
        }

        let token = new URLSearchParams(window.location.search).get('token');

        $.ajax({
            url: "{{ route('checkout.store') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                reservator_name: customerName,
                token:token
            },
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(res) {
                if(res.success){
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: res.message,
                });

                $("#cartModal").modal("hide");
                $("#cart-content").html("");
                $("#cart-count").text(0);

                // Kalau mau redirect ke halaman payment:
                window.location.href = "/payment/" + res.order_id;
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: res.message,
                });
            }
            }
        });
    });


});
</script>

<style>
    /* styling tombol keranjang mengambang */
    .cart-float {
        position: fixed;
        top: 80px;
        right: 20px;
    }
    .menu__order {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 10px;
    }
    .menu__qty {
        position: absolute;
        bottom: 0;
        left: 0;
        display: flex;
        padding: .35rem .813rem;
        border-radius: 0 .5rem 0 .5rem;
        width: 40%;
        border: 1px solid #ddd;
        text-align: center;
    }
    /* animasi shake */
    @keyframes shake {
    0%   { transform: translateX(0) rotate(0deg); }
    20%  { transform: translateX(-4px) rotate(-5deg); }
    40%  { transform: translateX(4px)  rotate(5deg); }
    60%  { transform: translateX(-4px) rotate(-5deg); }
    80%  { transform: translateX(4px)  rotate(5deg); }
    100% { transform: translateX(0) rotate(0deg); }
    }

    .shake {
    animation: shake 0.5s ease;
    }
</style>
@endsection
