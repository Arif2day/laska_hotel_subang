<!-- Nav Item - Tables -->


<!-- Divider -->
<hr class="sidebar-divider">
<!-- Heading -->
<div class="sidebar-heading">
    SUPER ADMIN
</div>

<li class="nav-item {{ request()->is('master*') ? 'active' : '' }}">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMaster"
        aria-expanded="true" aria-controls="collapseMaster">
        <i class="fas fa-fw fa-database"></i>
        <span>Master Data</span>
    </a>
    <div id="collapseMaster" class="collapse {{ request()->is('master*') ? 'show' : '' }}"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item {{ request()->is('master/user-manager') ? 'active' : '' }}" href="{{ url('master/user-manager') }}">
                Pengguna
            </a>
            <a class="collapse-item {{ request()->is('master/place-category') ? 'active' : '' }}" href="{{ url('master/place-category') }}">
                Kategori Tempat Order
            </a>
            <a class="collapse-item {{ request()->is('master/place') ? 'active' : '' }}" href="{{ url('master/place') }}">
                Tempat Order
            </a>
            <a class="collapse-item {{ request()->is('master/menu') ? 'active' : '' }}" href="{{ url('master/menu') }}">
                Menu
            </a>
            <a class="collapse-item {{ request()->is('master/menu-type') ? 'active' : '' }}" href="{{ url('master/menu-type') }}">
                Menu Types
            </a>
        </div>
    </div>
</li>

