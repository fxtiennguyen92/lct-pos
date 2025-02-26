@extends('template.base')

@push('wrapper')
    <section id="wrapper">
        <div class="login-register">
            <div class="login-box card">
                <div class="card-body">
                    <form method="post" action="{{ route('password.reset') }}">
                        @csrf
                        <h3 class="text-center m-b-20 m-t-20">{{ __('Reset Password') }}</h2>

                            @if ($errors->has('error') || $errors->has('token'))
                                <div class="alert alert-danger alert-dismissible">
                                    {{ $errors->first('error') ?: $errors->first('token') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true"></span></button>
                                </div>
                            @endif

                            <div class="form-group @error('email') has-danger @enderror">
                                <label class="form-label" for="email">{{ __('Email') }}</label>
                                <input id="email" class="form-control @error('email') form-control-danger @enderror"
                                    type="email" maxlength="120" placeholder="{{ __('Email') }}" name="email"
                                    value="{{ old('email', request()->get('email')) }}" required autocomplete="email">
                                @error('email')
                                    <small class="form-control-feedback">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group @error('password') has-danger @enderror">
                                <label class="form-label" for="password">{{ __('New password') }}</label>
                                <input id="password" class="form-control @error('password') form-control-danger @enderror"
                                    type="password" maxlength="250" placeholder="{{ __('New password') }}" name="password"
                                    required autofocus autocomplete="password">
                                @error('password')
                                    <small class="form-control-feedback">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="confirmPassword">{{ __('Confirm password') }}</label>
                                <input id="confirmPassword" class="form-control" type="password" maxlength="250"
                                    placeholder="{{ __('Confirm password') }}" name="password_confirmation" required>
                            </div>

                            <div class="form-group text-center p-b-10">
                                <div class="col-xs-12">
                                    <input type="hidden" name="token"
                                        value="{{ old('token', request()->get('token')) }}">
                                    <button class="btn btn-info btn-lg w-100 waves-effect waves-light text-white"
                                        type="submit">{{ __('Reset Password') }}</button>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="d-flex no-block align-items-center">
                                        <div class="ms-auto">
                                            <a href="{{ route('login') }}" id="to-login" class="text-info">
                                                <i class="align-middle ti-angle-left m-r-5"></i>
                                                {{ __('Back to log in') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="font-12 text-center text-muted">
                                © {{ now()->format('Y') . ' ' . config('app.name') }}
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endpush

@push('css')
    <link href="dist/css/pages/login-register-lock.css" rel="stylesheet">
@endpush

@push('js')
    <script type="text/javascript">
        $(function() {
            $(".preloader").fadeOut();
        });
    </script>
@endpush
