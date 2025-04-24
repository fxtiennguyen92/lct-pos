@if (Auth::user()->scope == App\ScopesEnum::SUPER->value)
    <li class="nav-small-cap text-uppercase">--- {{ __('Administration') }}</li>
    <li>
        <a id="projects" class="waves-effect waves-dark" href="{{ route('projects.index') }}" aria-expanded="false">
            <i class="ti-harddrives"></i><span class="hide-menu">{{ __('Projects') }}</span></a>
    </li>
@endif

{{-- @unlessrole(App\RolesEnum::STAFF->value)
    @if (session('projectCode'))
        <li class="nav-small-cap text-uppercase">--- {{ __('My business') }}</li>
        <li>
            <a id="dashboard" class="waves-effect waves-dark" href="{{ route('projects.show', session('projectCode')) }}"
                aria-expanded="false">
                <i class="ti-layout-grid2"></i><span class="hide-menu">{{ __('Dashboard') }}</span></a>
        </li>
        <li>
            <a id="schedule" class="waves-effect waves-dark" href="{{ route('schedule.index', session('projectCode')) }}"
                aria-expanded="false">
                <i class="icon-calender"></i><span class="hide-menu">{{ __('Schedule') }}</span></a>
        </li>
        <li>
            <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                <i class="icon-people"></i>
                <span class="hide-menu">{{ __('Human resources') }}</span>
            </a>
            <ul aria-expanded="false" class="collapse">
                <li>
                    <a id="accounts"
                        href="{{ route('project-accounts.index', session('projectCode')) }}">{{ __('Accounts') }}</a>
                </li>
            </ul>
        </li>
        <li>
            <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                <i class="icon-grid"></i>
                <span class="hide-menu">{{ __('Services') }}</span>
            </a>
            <ul aria-expanded="false" class="collapse">
                <li>
                    <a id="categories"
                        href="{{ route('categories.index', session('projectCode')) }}">{{ __('Categories') }}</a>
                </li>
            </ul>
        </li>
        <li>
            <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                <i class="ti-settings"></i>
                <span class="hide-menu">{{ __('Settings') }}</span>
            </a>
            <ul aria-expanded="false" class="collapse">
                <li>
                    <a id="working-hours" href="{{ route('settings.index', [session('projectCode'), session('branchCode')]) }}">{{ __('General settings') }}</a>
                </li>
                <li>
                    <a id="working-hours" href="{{ route('working-hours.edit', [session('projectCode'), session('branchCode')]) }}">{{ __('Working hours') }}</a>
                </li>
                <li>
                    <a id="special-hours" href="{{ route('special-hours.index', [session('projectCode'), session('branchCode')]) }}">{{ __('Special hours') }}</a>
                </li>
            </ul>
        </li>
    @endif
@endunlessrole --}}


@unlessrole(App\RolesEnum::STAFF->value)
    @if (session('projectCode'))
        {{-- Restaurant --}}
        @if (session('projectDomain') == App\DomainsEnum::RESTAURANT->value)
            <li class="nav-small-cap text-uppercase">--- {{ __('Restaurant') }}</li>
            <li>
                <a id="dashboard" class="waves-effect waves-dark" href="{{ route('projects.show', session('projectCode')) }}"
                    aria-expanded="false">
                    <i class="ti-layout-grid2"></i><span class="hide-menu">{{ __('Dashboard') }}</span></a>
            </li>

            {{-- Reservation --}}
            <li class="nav-small-cap text-uppercase">--- {{ __('Reservation') }}</li>
            <li>
                <a id="pending-reservation" class="waves-effect waves-dark"
                    href="{{ route('restaurant.reservation.index.pending', [session('projectCode'), session('branchCode')]) }}"
                    aria-expanded="false">
                    <i class="ti-comments"></i><span class="hide-menu">{{ __('Pending') }}
                        <span class="badge rounded-pill bg-primary text-white ms-auto">25</span>
                    </span></a>
            </li>
            <li>
                <a id="accepted-reservation" class="waves-effect waves-dark"
                    href="{{ route('restaurant.reservation.index.accepted', [session('projectCode'), session('branchCode')]) }}"
                    aria-expanded="false">
                    <i class="ti-calendar"></i><span class="hide-menu">{{ __('Accepted') }}</span></a>
            </li>

            {{-- Settings --}}
            <li class="nav-small-cap text-uppercase">--- {{ __('Settings') }}</li>
            <li>
                <a id="special-hours" class="waves-effect waves-dark"
                    href="{{ route('special-hours.index', [session('projectCode'), session('branchCode')]) }}"
                    aria-expanded="false">
                    <i class="ti-bolt"></i><span class="hide-menu">{{ __('Special hours') }}</span></a>
            </li>
            <li>
                <a id="working-hours" class="waves-effect waves-dark"
                    href="{{ route('working-hours.edit', [session('projectCode'), session('branchCode')]) }}"
                    aria-expanded="false">
                    <i class="ti-alarm-clock"></i><span class="hide-menu">{{ __('Opening hours') }}</span></a>
            </li>
            <li>
                <a id="settings" class="waves-effect waves-dark"
                    href="{{ route('settings.index', [session('projectCode'), session('branchCode')]) }}"
                    aria-expanded="false">
                    <i class="ti-settings"></i><span class="hide-menu">{{ __('Settings') }}</span></a>
            </li>
        @endif
    @endif
@endunlessrole



<li class="nav-small-cap text-uppercase">--- {{ __('Support') }}</li>
<li>
    <a class="waves-effect waves-dark" href="{{ route('logout') }}" aria-expanded="false">
        <i class="icon-logout"></i><span class="hide-menu">{{ __('Log out') }}</span></a>
</li>
