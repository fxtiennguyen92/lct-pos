<li class="nav-small-cap">--- {{ __('dashboard') }}</li>

<li>
    <a class="waves-effect waves-dark" href="{{ route('dashboard') }}" aria-expanded="false">
        <i class="ti-layout-grid2"></i><span class="hide-menu">{{ __('dashboard') }}</span></a>
</li>

<li>
    {{-- Settings --}}
    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
        <i class="icon-feed"></i>
        <span class="hide-menu">{{ __('text.sidebar.posts') }}</span>
    </a>
    <ul aria-expanded="false" class="collapse">
        <li>
            <a id="#" href="#">asdfasd</a>
        </li>
    </ul>
</li>
<li class="nav-small-cap">--- {{ __('support') }}</li>
<li>
    <a class="waves-effect waves-dark" href="{{ route('logout') }}" aria-expanded="false">
        <i class="icon-logout"></i><span class="hide-menu">{{ __('logout') }}</span></a>
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
