@if (Auth::user()->scope == App\ScopesEnum::SUPER->value)
    <li class="nav-small-cap text-uppercase">--- {{ __('Administration') }}</li>
    <li>
        <a id="projects" class="waves-effect waves-dark" href="{{ route('projects.index') }}" aria-expanded="false">
            <i class="ti-harddrives"></i><span class="hide-menu">{{ __('Projects') }}</span></a>
    </li>
@endif

@unlessrole(App\RolesEnum::STAFF->value)
    @if (session('projectCode'))
        <li class="nav-small-cap text-uppercase">--- {{ __('My business') }}</li>
        <li>
            <a id="dashboard" class="waves-effect waves-dark" href="{{ route('projects.show', session('projectCode')) }}"
                aria-expanded="false">
                <i class="ti-layout-grid2"></i><span class="hide-menu">{{ __('Dashboard') }}</span></a>
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
                <i class="ti-settings"></i>
                <span class="hide-menu">{{ __('Settings') }}</span>
            </a>
            <ul aria-expanded="false" class="collapse">
                <li>
                    <a id="working-hours" href="{{ route('working-hours.edit', session('projectCode')) }}">{{ __('Working hours') }}</a>
                </li>
                <li>
                    <a id="special-hours" href="{{ route('special-hours.index', session('projectCode')) }}">{{ __('Special hours') }}</a>
                </li>
            </ul>
        </li>
    @endif
@endunlessrole


<li class="nav-small-cap text-uppercase">--- {{ __('Dashboard') }}</li>
<li>
    <a class="waves-effect waves-dark" href="{{ route('dashboard') }}" aria-expanded="false">
        <i class="ti-layout-grid2"></i><span class="hide-menu">{{ __('Dashboard') }}</span></a>
</li>

<li class="nav-small-cap text-uppercase">--- {{ __('Settings') }}</li>
<li>
    {{-- Settings --}}
    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
        <i class="ti-briefcase"></i>
        <span class="hide-menu">{{ __('Business') }}</span>
    </a>
    <ul aria-expanded="false" class="collapse">
       
    </ul>
</li>
<li class="nav-small-cap">--- {{ __('Support') }}</li>
<li>
    <a class="waves-effect waves-dark" href="{{ route('logout') }}" aria-expanded="false">
        <i class="icon-logout"></i><span class="hide-menu">{{ __('Log out') }}</span></a>
</li>

<li>
    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
        <i class="icon-speedometer"></i><span class="hide-menu">Dashboard <span
                class="badge rounded-pill bg-cyan ms-auto">4</span></span></a>
    <ul aria-expanded="false" class="collapse">
        <li><a href="index.html">Minimal </a></li>
        <li><a href="index2.html">Analytical</a></li>
        <li><a href="index3.html">Demographical</a></li>
        <li><a href="index4.html">Modern</a></li>
    </ul>
</li>
