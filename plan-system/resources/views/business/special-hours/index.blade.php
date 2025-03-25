@extends('template.index')

@push('content')
    <!-- Bread crumb and right sidebar toggle -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">{{ session('projectName') }}</h4>
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
                                    <th>{{ __('Date') }}</th>
                                    @if ($branch->setting->outside_flg)
                                        <th class="text-center">{{ __('Position') }}</th>
                                    @endif
                                    <th class="text-center">{{ __('Status') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($specialHours as $hour)
                                    <tr>
                                        <th>
                                            @if ($hour->start_date->format('d-m-Y') === $hour->end_date->format('d-m-Y'))
                                                <span class="me-4 no-wrap"><i class=" ti-calendar me-1"></i>
                                                    {{ $hour->start_date->locale(app()->getLocale())->isoFormat('ddd, DD-MM-YYYY') }}</span>
                                                <span class="me-4 no-wrap"><i class="ti-alarm-clock me-1"></i>
                                                    {{ $hour->start_date->format('H:i') . ' - ' . $hour->end_date->format('H:i') }}</span>
                                            @else
                                                <span class="no-wrap"><i class="ti-calendar me-1"></i>
                                                    {{ $hour->start_date->locale(app()->getLocale())->isoFormat('ddd, DD-MM-YYYY HH:mm') }}</span>
                                                <span class="mx-2"></span>
                                                <span class="no-wrap"><i class="ti-calendar me-1"></i>
                                                    {{ $hour->end_date->locale(app()->getLocale())->isoFormat('ddd, DD-MM-YYYY HH:mm') }}</span>
                                            @endif
                                        </th>
                                        @if ($branch->setting->outside_flg)
                                            <td class="text-center">
                                                @if ($hour->position == App\RestaurantPositionsEnum::WHOLE->value)
                                                    <span class="label label-info">{{ App\RestaurantPositionsEnum::WHOLE->label() }}</span>
                                                @endif
                                                @if ($hour->position == App\RestaurantPositionsEnum::INSIDE->value)
                                                    <span class="label label-success">{{ App\RestaurantPositionsEnum::INSIDE->label() }}</span>
                                                @endif
                                                @if ($hour->position == App\RestaurantPositionsEnum::OUTSIDE->value)
                                                    <span class="label label-warning">{{ App\RestaurantPositionsEnum::OUTSIDE->label() }}</span>
                                                @endif
                                            </td>
                                        @endif
                                        <td class="text-center">
                                            @if ($hour->close_flg)
                                                <span class="label label-danger">{{ __('Close') }}</span>
                                            @else
                                                <span class="label label-info">{{ __('Open') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" data-href="{{ $hour->id }}"
                                                class="btn-delete btn btn-sm waves-effect waves-light btn-outline-danger no-wrap"><i
                                                    class="ti-trash me-1"></i>{{ __('Delete') }}</button>
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
                    <h4 class="modal-title font-normal">{{ __('Add new') }}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="false"></button>
                </div>
                <div class="modal-body">
                    <div id="createErrorMessage" class="alert alert-danger" style="display: none;"></div>
                    <form id="createForm" method="post"
                        action="{{ route('special-hours.store', [session('projectCode'), session('branchCode')]) }}">
                        @csrf
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Date') }}</label>
                                    <input type="text" class="form-control special-date mb-2" placeholder="DD-MM-YYYY"
                                        name="date" maxlength="10">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Start date') }}</label>
                                    <input type="text" class="form-control start-time mb-2" placeholder="00:00"
                                        name="start_time" maxlength="5">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">{{ __('End date') }}</label>
                                    <input type="text" class="form-control end-time mb-2" placeholder="00:00"
                                        name="end_time" maxlength="5">
                                </div>
                            </div>
                            @if ($branch->setting->outside_flg)
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label" for="position">{{ __('Position') }}</label>
                                        <select class="form-select" id="status" name="position">
                                            @foreach (App\RestaurantPositionsEnum::values() as $key => $position)
                                                <option value="{{ $key }}">{{ $position }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button"
                        class="btn btn-info btn-create waves-effect waves-light text-white">{{ __('Save') }}</button>
                    <button type="button" class="btn btn-dark waves-effect"
                        data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                </div>
            </div>
        </div>
    </div>

    <form id="deleteForm" method="post" action="">
        @csrf @method('delete')
    </form>
@endpush

@push('css')
    <link href="assets/node_modules/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css"
        rel="stylesheet">
    <link href="assets/node_modules/bootstrap-switch/bootstrap-switch.min.css" rel="stylesheet">
@endpush

@push('js')
    <script src="dist/js/moment-with-locales.min.js"></script>
    <script src="assets/node_modules/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
    <script src="assets/node_modules/bootstrap-switch/bootstrap-switch.min.js"></script>

    <script>
        $('.special-date').bootstrapMaterialDatePicker({
            format: 'DD-MM-YYYY',
            time: false,
            lang: @json(str_replace('_', '-', app()->getLocale())),
            cancelText: @json(__('Back')),
            minDate: new Date(),
        })

        $('.start-time').bootstrapMaterialDatePicker({
            format: 'HH:mm',
            time: true,
            date: false,
            lang: @json(str_replace('_', '-', app()->getLocale())),
            cancelText: @json(__('Back')),
        }).on('change', function(e, date) {
            $('.end-time').bootstrapMaterialDatePicker('setMinDate', date);
        });

        $('.end-time').bootstrapMaterialDatePicker({
            format: 'HH:mm',
            time: true,
            date: false,
            lang: @json(str_replace('_', '-', app()->getLocale())),
            cancelText: @json(__('Back')),
        });

        $(".bt-switch input[type='checkbox']").bootstrapSwitch();

        $('.btn-create').click(function(e) {
            e.preventDefault();
            $(this).prop('disabled', true);

            updatingSwal = Swal.fire({
                title: @json(__('Updating') . ' ...'),
                allowOutsideClick: false,
                allowEscapeKey: false,
                onBeforeOpen: () => {
                    Swal.showLoading()
                },
            });

            $.ajax({
                url: $('#createForm').attr('action'),
                type: 'POST',
                data: $('#createForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#createErrorMessage').html('');
                        $('#createErrorMessage').hide();

                        location.reload(true);
                    } else {
                        console.log(response);
                        $('#createErrorMessage').html(response.error);
                        $('#createErrorMessage').show();
                    }
                },
                error: function(xhr, status, error) {
                    $.toast({
                        heading: @json(__('Error')),
                        text: @json(__('messages.update.failed')),
                        position: 'bottom-right',
                        icon: 'error',
                        loader: false,
                        hideAfter: 4000,
                    });
                },
                complete: function(data) {
                    updatingSwal.close();
                    $('.btn-create').prop('disabled', false);
                }
            });
        });

        $('.btn-delete').click(function(e) {
            e.preventDefault();
            $(this).prop('disabled', true);
            rowId = $(this).data("href");

            Swal.fire({
                title: @json(__('Delete')),
                text: @json(__('Do you want to delete this data ?')),
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: @json(__('Confirm')),
                cancelButtonText: @json(__('Cancel')),
            }).then((result) => {
                if (result.value) {
                    url =
                        "{{ route('special-hours.destroy', [session('projectCode'), session('branchCode'), 'rowId']) }}";
                    url = url.replace('rowId', rowId);

                    $('#deleteForm').attr('action', url);
                    $('#deleteForm').submit();
                } else {
                    $(this).prop('disabled', false);
                    return false;
                }
            });
        });

        @if (session('success'))
            $.toast({
                heading: "{{ __('Success') }}",
                text: "{{ session('success') }}",
                position: 'bottom-right',
                icon: 'success',
                loader: false,
                hideAfter: 3000,
            });
        @endif
    </script>
@endpush
