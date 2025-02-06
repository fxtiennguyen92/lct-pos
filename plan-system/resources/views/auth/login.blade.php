@extends('template.base')

@push('wrapper')
    <section id="wrapper">
        <div class="login-register">
            <div class="login-box card">
                <div class="card-body">
                    <!-- Log in -->
                    <form id="loginform" method="post" action="{{ route('login') }}">
                        @csrf
                        <h2 class="text-center m-b-20 m-t-20">{{ __('Admin system') }}</h2>

                        @error('error')
                            <div class="alert alert-danger alert-dismissible">
                                {{ $message }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true"></span></button>
                            </div>
                        @enderror

                        <div class="form-group @error('email') has-danger @enderror">
                            <label class="form-label" for="email">{{ __('Email') }}</label>
                            <input id="email" class="form-control @error('email') form-control-danger @enderror"
                                type="email" maxlength="120" placeholder="{{ __('Email') }}" name="email"
                                value="{{ old('email') }}" autofocus required autocomplete="email">
                            @error('email')
                                <small class="form-control-feedback">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group @error('password') has-danger @enderror">
                            <label class="form-label" for="password">{{ __('Password') }}</label>
                            <input id="password" class="form-control @error('password') form-control-danger @enderror"
                                type="password" maxlength="250" placeholder="{{ __('Password') }}" name="password" required
                                autocomplete="password">
                            @error('password')
                                <small class="form-control-feedback">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="d-flex no-block align-items-center">
                                    <div class="ms-auto">
                                        <a href="javascript:void(0)" id="to-recover" class="text-dark">
                                            <i class="ti-lock m-r-5"></i> {{ __('Forgot password ?') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <div class="col-xs-12">
                                <button class="btn w-100 btn-lg btn-info text-white waves-effect waves-light"
                                    type="submit">{{ __('Log in') }}</button>
                            </div>
                        </div>
                    </form>

                    <!-- Forgot password -->
                    <form id="recoverform" method="post" action="{{ route('password.request') }}">
                        @csrf
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <h2 class="m-t-20 text-center text-muted">{{ __('Forgot password ?') }}</h2>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="resetEmail">{{ __('Email') }}</label>
                            <input id="resetEmail" class="form-control @error('email') form-control-danger @enderror"
                                type="email" maxlength="120" placeholder="{{ __('Email') }}" name="email"
                                value="{{ old('email') }}" autofocus required autocomplete="email">
                            @error('email')
                                <small class="form-control-feedback">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button class="btn w-100 btn-lg btn-info text-white waves-effect waves-light"
                                    type="submit">{{ __('Recover password') }}</button>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="d-flex no-block align-items-center">
                                    <div class="ms-auto">
                                        <a href="{{ route('login') }}" id="to-login" class="text-muted">
                                            <i class="align-middle ti-angle-left m-r-5"></i>
                                            {{ __('Back to log in') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="text-center m-t-20">
                        @foreach (\App\Models\Language::getList() as $language)
                            @if (app()->getLocale() == $language->locale)
                                <strong class="m-10 font-weight-bold text-info">{{ $language->name }}</strong>
                            @else
                                <a class="m-10 waves-effect waves-light text-muted"
                                    href="{{ route('change.locale', $language->locale) }}">
                                    {{ $language->name }}
                                </a>
                            @endif
                        @endforeach
                    </div>

                    <div class="font-12 text-center text-muted">
                        © {{ now()->format('Y') . ' ' . config('app.name') }}
                    </div>
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
            'use strict';
            $(".preloader").fadeOut();
            $("input[id='email']").focus();
        });

        $('#to-recover').on("click", function() {
            $('input.form-control').val('');
            $("#loginform").slideUp();
            $("#recoverform").fadeIn();
            $("input[id='resetEmail']").focus();
        });

        $(document).ready(function() {
            $('form').submit(function(event) {
                $(this).find('button').prop('disabled', true);
            });

            @if (session('info'))
                $.toast({
                    heading: "{{ __('Info') }}",
                    text: "{{ session('info') }}",
                    position: 'top-right',
                    icon: 'success',
                    loader: false,
                    hideAfter: 4000,
                });
            @endif
        });
    </script>
@endpush
