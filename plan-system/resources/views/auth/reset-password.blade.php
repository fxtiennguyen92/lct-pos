@extends('template.base')

@push('wrapper')
    <section id="wrapper">
        <div class="login-register">
            <div class="login-box card">
                <div class="card-body">
                    <!-- Log in -->
                    <form class="form-horizontal form-material" id="loginform" action="">
                        <h2 class="text-center m-b-20 m-t-20">Reset Password</h2>
                        <div class="alert alert-danger alert-dismissible">
                            {{ __('auth.failed') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true"></span></button>
                        </div>
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="text" maxlength="50" placeholder="Username"
                                    name="username" value="{{ old('username') }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" type="password" maxlength="150" placeholder="New Password"
                                    name="password" required>
                            </div>
                        </div>
                        <div class="form-group text-center p-b-10">
                            <div class="col-xs-12">
                                <button class="btn btn-info btn-lg w-100 text-uppercase waves-effect waves-light text-white" type="submit">Reset</button>
                            </div>
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
