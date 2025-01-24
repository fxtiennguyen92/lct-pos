<div class="user-profile">
    <div class="user-pro-body">
        <div>
            <img src="{{ auth()->user->avatar ?? 'assets/images/users/1.jpg' }}" alt="{{ auth()->user->name ?? 'Administrator' }}" class="img-circle">
        </div>
        <div class="dropdown">
            <a href="javascript:void(0)" class="dropdown-toggle u-dropdown link hide-menu" data-bs-toggle="dropdown"
                role="button" aria-haspopup="true" aria-expanded="false">{{ auth()->user()->name ?? 'User' }}
                <span class="caret"></span>
            </a>
            <div class="dropdown-menu animated flipInY">
                <a href="" class="dropdown-item">
                    <i class="icon-user me-1"></i> {{ __('text.profile') }}</a>

                <a href="" class="dropdown-item">
                    <i class="icon-key me-1"></i> {{ __('text.sidebar.password') }}</a>

                <!-- Log out -->
                <div class="dropdown-divider"></div>
                <a href="{{ route('logout') }}" class="dropdown-item">
                    <i class="icon-logout me-1"></i> {{ __('text.buttons.logout') }}</a>
            </div>
        </div>
    </div>
</div>
