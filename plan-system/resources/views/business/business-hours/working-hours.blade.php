@extends('template.index')

@push('content')
    <!-- Bread crumb and right sidebar toggle -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">{{ __('Working hours') }}</h4>
        </div>
    </div>

    <!-- Page content -->
    <div class="row">
        <div class="col-lg-8 col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Control Icons</h4>
                    <h6 class="card-subtitle">use class <code>icon-</code> icon name in i tag</h6>

                    <div class="row">
                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-3 col-form-label">
                                <input type="checkbox" class="form-check-input me-2" checked>
                                {{ __('Monday') }}
                            </label>
                            <div class="col-md-6">
                                <div class="input-group mb-2">
                                    <input type="text" class="clockpicker form-control text-center" value="09:30">
                                    <span class="input-group-text">{{ __('-') }}</span>
                                    <input type="text" class="clockpicker form-control text-center" value="09:30">
                                </div>
                            </div>
                        </div>



                        <div class="col-md-2">
                            <div class="form-check mr-sm-2 mb-2">
                                <input type="checkbox" class="form-check-input" id="checkbox0" value="check">
                                <label class="form-check-label" for="checkbox0">{{ __('Monday') }}</label>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-5 col-sm-6">
                                    <div class="input-group mb-2 clockpicker">
                                        <span class="input-group-text">{{ __('From') }}</span>
                                        <input type="text" class="form-control text-end" value="09:30">
                                    </div>
                                </div>
                                <div class="col-md-5 col-sm-6">
                                    <div class="input-group mb-2 clockpicker">
                                        <span class="input-group-text">{{ __('To') }}</span>
                                        <input type="text" class="form-control text-end" value="09:30">
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-12">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">{{ __('Actions') }}</h4>
                    <div>
                        <button type="button"
                            class="btn-update btn btn-success me-2 text-white">{{ __('Update') }}</button>
                        <a href="{{ route('project-accounts.index', session('projectCode')) }}"
                            class="btn btn-dark text-white">{{ __('Back') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('css')
    <link href="assets/node_modules/clockpicker/dist/jquery-clockpicker.min.css" rel="stylesheet">
@endpush

@push('js')
    <script src="assets/node_modules/clockpicker/dist/jquery-clockpicker.min.js"></script>

    <script>
        $('.clockpicker').clockpicker({
            donetext: @json(__('Select')),
        });
    </script>
@endpush
