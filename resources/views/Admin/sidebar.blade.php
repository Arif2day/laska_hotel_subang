<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-feedermate sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{url('dashboard')}}">
        <div class="sidebar-brand-icon">
            <img src="{{asset('img/court.png')}}" alt="LASKA HOTEL SUBANG" height="40px">
        </div>
        <div class="sidebar-brand-text mx-3">
            LASKA&nbsp;HOTEL
            {{-- <sup>2</sup> --}}
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ 
        request()->is('dashboard') ? 'active' : '' 
        }}">
        <a class="nav-link" href="{{url('dashboard')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>


    

    <!-- Nav Item - Charts -->
    <li class="nav-item {{ 
            request()->is('user-profile') ? 'active' : '' 
            }}">
        <a class="nav-link" href="{{url('user-profile')}}">
            <i class="fas fa-fw fa-id-badge"></i>
            <span>Profile</span></a>
    </li>
    <li class="nav-item {{ request()->is('order*') ? 'active' : '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOrder"
            aria-expanded="true" aria-controls="collapseOrder">
            <i class="fas fa-fw fa-database"></i>
            <span>Order</span>
        </a>
        <div id="collapseOrder" class="collapse {{ request()->is('order*') ? 'show' : '' }}"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->is('order/live') ? 'active' : '' }}" href="{{ url('order/live') }}">
                    Live Order
                </a>
                <a class="collapse-item {{ request()->is('order/riwayat') ? 'active' : '' }}" href="{{ url('order/riwayat') }}">                    
                    Riwayat Order
                </a>
            </div>
        </div>
    </li>
    
    
    @if((Sentinel::getUser()->inRole('koki')))
    @include('Admin.sidebar-detail.menu-koki')
    @endif

    @if((Sentinel::getUser()->inRole('super-admin')))
    @include('Admin.sidebar-detail.menu-sadmin')
    @endif 


    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->