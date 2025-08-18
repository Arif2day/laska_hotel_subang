<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!--========== BOX ICONS ==========-->
        <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>

        <!--========== CSS ==========-->
        {!!Html::style('css/sb-admin-2.min.css')!!}
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">

        <title>Laska Restaurant</title>
    </head>
    <body>

        <!--========== SCROLL TOP ==========-->
        <a href="#" class="scrolltop" id="scroll-top">
            <i class='bx bx-chevron-up scrolltop__icon'></i>
        </a>

        <!--========== HEADER ==========-->
        <header class="l-header" id="header">
            <nav class="nav bd-container">
                <a href="#" class="nav__logo">Laska Restaurant</a>

                <div class="nav__menu" id="nav-menu">
                    <ul class="nav__list">
                        <li class="nav__item" id="nav-home"><a href="{{ url('/') }}#home" class="nav__link {{ request()->is('/') ? 'active-link' : '' }}">Home</a></li>
                        <li class="nav__item" id="nav-about"><a href="{{ url('/') }}#about" class="nav__link">About</a></li>
                        <li class="nav__item" id="nav-service"><a href="{{ url('/') }}#services" class="nav__link">Services</a></li>
                        
                        <li class="nav__item">
                            @if(isset($pendingOrder) && $pendingOrder)
                                <a href="{{ url('payment/' . $pendingOrder->id . '?token=' . $token) }}" 
                                class="nav__link active-link">
                                    Lanjut ke Pembayaran
                                </a>
                            @elseif (isset($onProcessOrder)&& $onProcessOrder)
                                <a href="{{ url('payment/' . $onProcessOrder->id . '?token=' . $token) }}" 
                                class="nav__link active-link">
                                    Orderan Saya
                                </a>
                            @elseif (isset($cart)&& $cart)
                                <a href="{{ url('menu'. '?token=' . $token) }}" 
                                class="nav__link active-link">
                                    Keranjang
                                </a>
                            @else
                                <a href="{{ url('/scan') }}" 
                                class="nav__link {{ request()->is('scan') || request()->is('menu') ? 'active-link' : '' }}">
                                    Order
                                </a>
                            @endif
                        </li>
                        
                        
                        <li class="nav__item" id="nav-contact"><a href="{{ url('/') }}#contact" class="nav__link">Contact us</a></li>

                        <li><i class='bx bx-moon change-theme' id="theme-button"></i></li>
                    </ul>
                </div>

                <div class="nav__toggle" id="nav-toggle">
                    <i class='bx bx-menu'></i>
                </div>
            </nav>
        </header>

        @yield('content')

        @include('Guest.footer')

        <!--========== SCROLL REVEAL ==========-->
        <script src="https://unpkg.com/scrollreveal"></script>

        <!--========== MAIN JS ==========-->
        {!!Html::script('vendor/jquery/jquery.min.js')!!}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        {!!Html::script('vendor/bootstrap/js/bootstrap.bundle.min.js')!!}
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script src="{{ asset('assets/js/main.js') }}"></script>
        
        @yield('script')
    </body>
</html>