<p>{{ __('hello') }}</p>
<p>{{ __('reset-password-click-link') }} <b>{{ $user->email }}</b></p>
<p>
    <a href="{{ $resetUrl }}" target="_blank">{{ $resetUrl }}</a>
</p>
<p>{{ __('reset-password-warning') }}</p>
<p>{{ __('reset-password-thanks') }}</p>
<p>{{ __('team-signature') . config('app.name') }}</p>
