<div class="navbar-collapse">
    <!-- Toggle and Nav items -->
    <ul class="navbar-nav me-auto">
        <li class="nav-item">
            <a class="nav-link nav-toggler d-block d-md-none waves-effect waves-dark"
                href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
        <li class="nav-item">
            <a class="nav-link sidebartoggler d-none d-lg-block d-md-block waves-effect waves-dark"
                href="javascript:void(0)"><i class="icon-menu"></i></a> </li>
        <!-- Search -->
        {{-- <li class="nav-item">
            <form class="app-search d-none d-md-block d-lg-block">
                <input type="text" class="form-control" placeholder="Search user ...">
            </form>
        </li> --}}
    </ul>

    <ul class="navbar-nav my-lg-0">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-bs-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="ti-email"></i>
                <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
            </a>
        </li>
        <li class="nav-item right-side-toggle">
            <a class="nav-link waves-effect waves-light" href="{{ route('logout') }}">
                <i class="ti-power-off"></i></a>
        </li>
    </ul>
</div>
