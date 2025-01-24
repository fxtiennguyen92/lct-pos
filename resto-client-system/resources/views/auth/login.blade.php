@extends('template.base')

@push('wrapper')
    <section id="wrapper">
        <div class="login-register">
            <div class="login-box card">
                <div class="card-body">
                    <!-- Log in -->
                    <form class="form-horizontal form-material" id="loginform" method="post" action="{{ route('login') }}">
                        @csrf
                        <h2 class="text-center m-b-20 m-t-20">{{ __('text.admin') }}</h2>

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible">
                                {{ $errors->first() }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true"></span></button>
                            </div>
                        @endif

                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input id="email" class="form-control" type="email" maxlength="100"
                                    placeholder="{{ __('validation.attributes.email') }}" name="email"
                                    value="{{ old('email') }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" type="password" maxlength="150"
                                    placeholder="{{ __('validation.attributes.password') }}" name="password" required
                                    autocomplete="on">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="d-flex no-block align-items-center">
                                    <div class="ms-auto">
                                        <a href="javascript:void(0)" id="to-recover" class="text-muted">
                                            <i class="ti-lock m-r-5"></i> {{ __('text.forgot_password') }}?</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <div class="col-xs-12">
                                <button class="btn w-100 btn-lg btn-primary text-white"
                                    type="submit">{{ __('text.buttons.login') }}</button>
                            </div>
                        </div>
                    </form>

                    <!-- Forgot password -->
                    <form class="form-horizontal form-material" id="recoverform" method="post"
                        action="{{ route('password.request') }}">
                        @csrf
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <h2 class="m-t-20">{{ __('text.recover_password') }}</h2>
                                <p class="text-muted">{{ __('text.recover_password_subtext') }}</p>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input id="resetEmail" class="form-control" type="email" placeholder="Email" name="email" required
                                    autocomplete="on">
                            </div>
                        </div>
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button class="btn btn-primary btn-lg w-100 waves-effect waves-light"
                                    type="submit">{{ __('text.buttons.send_recover_password_link') }}</button>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="d-flex no-block align-items-center">
                                    <div class="ms-auto">
                                        <a href="javascript:void(0)" id="to-login" class="text-muted">
                                            <i class="align-middle ti-angle-left m-r-5"></i> {{ __('text.buttons.back') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="text-center text-muted"><small>© {{ now()->format('Y') . config('app.name') }} </small></div>
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

        $('#to-login').on("click", function() {
            $('input.form-control').val('');
            $("#recoverform").slideUp();
            $("#loginform").fadeIn();
            $("input[id='email']").focus();
        });

        $(document).ready(function() {
            $('form').submit(function(event) {
                $(this).find('button').prop('disabled', true);
            });
        });
    </script>
@endpush
