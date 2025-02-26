<div class="navbar-collapse">
    <!-- Toggle and Nav items -->
    <ul class="navbar-nav me-auto">
        <li class="nav-item">
            <a class="nav-link nav-toggler d-block d-md-none waves-effect waves-dark" href="javascript:void(0)"><i
                    class="ti-menu"></i></a>
        </li>
        <li class="nav-item">
            <a class="nav-link sidebartoggler d-none d-lg-block d-md-block waves-effect waves-dark"
                href="javascript:void(0)"><i class="icon-menu"></i></a>
        </li>
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
                aria-haspopup="true" aria-expanded="false" title="{{ __('Languages') }}">
                <i class="icon-globe"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-end animated flipInY">
                @foreach (\App\Models\Language::getList() as $language)
                    @if (app()->getLocale() == $language->locale)
                        <a class="dropdown-item disabled" href="#" disable>
                            <i class="flag-icon flag-icon-{{ $language->flag_code }}" title="{{ $language->name }}"></i>
                            <strong class="text-dark">{{ $language->name }}</strong></a>
                    @else
                        <a class="dropdown-item text-muted" href="{{ route('change.locale', $language->locale) }}">
                            <i class="flag-icon flag-icon-{{ $language->flag_code }}" title="{{ $language->name }}"></i>
                            {{ $language->name }}
                        </a>
                    @endif
                @endforeach
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-bs-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="icon-bell"></i>
                <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
            </a>
            <div class="dropdown-menu mailbox dropdown-menu-end animated bounceInDown">
                <ul>
                    <li>
                        <div class="drop-title">You have 4 new messages</div>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
</div>
