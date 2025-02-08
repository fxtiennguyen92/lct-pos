<li class="user-pro">
    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><img
            src="{{ Auth::user()->profile_photo_path }}" alt="{{ Auth::user()->name }}" class="img-circle">
            <span class="hide-menu">{{ Auth::user()->name ?? 'User' }}</span></a>
    <ul aria-expanded="false" class="collapse">
        <li><a href="javascript:void(0)"><i class="ti-user"></i> My Profile</a></li>
        <li><a href="javascript:void(0)"><i class="ti-wallet"></i> My Balance</a></li>
        <li><a href="javascript:void(0)"><i class="ti-email"></i> Inbox</a></li>
        <li><a href="javascript:void(0)"><i class="ti-settings"></i> Account Setting</a></li>
        <li><a href="{{ route('logout') }}"><i class="icon-logout"></i> {{ __('logout') }}</a></li>
    </ul>
</li>