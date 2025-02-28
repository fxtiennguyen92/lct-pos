@extends('template.index')

@push('content')
    <!-- Bread crumb and right sidebar toggle -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">{{ __('Special hours') }}</h4>
        </div>
        <div class="col-md-7 align-self-center text-end">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item">{{ __('My business') }}</li>
                    <li class="breadcrumb-item">{{ __('Settings') }}</li>
                    <li class="breadcrumb-item active">{{ __('Special hours') }}</li>
                </ol>
            </div>
        </div>
    </div>

    <!-- Page content -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title text-uppercase m-t-10">{{ __('Special hours') }}</h5>

                        <a class="btn btn-info text-white" data-bs-toggle="modal" data-bs-target="#new-modal">
                            <i class="ti-plus"></i> {{ __('Add new') }}</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>{{ __('Type') }}</th>
                                    <th>{{ __('Date') }}</th>
                                    <th>{{ __('Time') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($specialHours as $hour)
                                    <tr>
                                        <td class="text-center">
                                            @if ($hour->open_flg)
                                                <i class="label label-info ti-thumb-up" title="{{ __('Open') }}"></i>
                                            @else
                                                <i class="label label-danger icon-close" title="{{ __('Close') }}"></i>
                                            @endif
                                        </td>
                                        <th>{{ $hour->date->format('DD-MM-YYYY') }}</th>

                                        <td>{{ $hour->open_time->format('HH:ii') . ' - ' . $hour->close_time->format('HH:ii') }}
                                        </td>
                                    <tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div>
                            {{ $specialHours->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="new-modal" class="modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('Add new special hour') }}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">{{ __('Date') }}</label>
                                <input type="text" class="form-control open-date" placeholder="DD-MM-YYYY HH:MM">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">{{ __('Date') }}</label>
                                <input type="text" class="form-control close-date" placeholder="DD-MM-YYYY HH:MM">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class='input-group mb-3'>
                                <input type='text' class="form-control timeseconds" />

                                <div class="input-group">
                                    <input type="text" class="clockpicker form-control text-center" placeholder="00:00"
                                        name="open_time">
                                    <span class="input-group-text">{{ __('-') }}</span>
                                    <input type="text" class="clockpicker form-control text-center" placeholder="00:00"
                                        name="close_time">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger waves-effect waves-light text-white">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('css')
    <link href="assets/node_modules/clockpicker/dist/jquery-clockpicker.min.css" rel="stylesheet">
    <link href="assets/node_modules/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css"
        rel="stylesheet">
@endpush

@push('js')
    <script src="dist/js/moment-with-locales.min.js"></script>
    <script src="assets/node_modules/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
    <script src="assets/node_modules/clockpicker/dist/jquery-clockpicker.min.js"></script>
    <script>
        $('.open-date').bootstrapMaterialDatePicker({
            format: 'DD/MM/YYYY hh:mm',
            lang: @json(str_replace('_', '-', app()->getLocale())),
            minDate: new Date(),
            switchOnClick: true,
        }).on('change', function(e, date) {
            $('.close-date').bootstrapMaterialDatePicker('setMinDate', date);
        });

        $('.close-date').bootstrapMaterialDatePicker({
            format: 'DD/MM/YYYY hh:mm',
            lang: @json(str_replace('_', '-', app()->getLocale())),
            switchOnClick: true,
        });
    </script>
@endpush
