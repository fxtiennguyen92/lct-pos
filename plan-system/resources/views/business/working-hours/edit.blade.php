@extends('template.index')

@push('content')
    <!-- Bread crumb and right sidebar toggle -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">{{ __('Working hours') }}</h4>
        </div>
        <div class="col-md-7 align-self-center text-end">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item">{{ __('My business') }}</li>
                    <li class="breadcrumb-item">{{ __('Settings') }}</li>
                    <li class="breadcrumb-item active">{{ __('Working hours') }}</li>
                </ol>
            </div>
        </div>
    </div>

    <!-- Page content -->
    <form id="submitForm" method="post" action="{{ route('working-hours.update', session('projectCode')) }}">
        @csrf
        <div class="row">
            <div class="col-lg-8 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ __('Set standard hours') }}</h4>
                        <h6 class="card-subtitle mb-4">
                            {{ __('Configure the standard hours of operation for this location') }}
                        </h6>
                        <div id="errorMessage" class="alert alert-danger" style="display: none"></div>

                        <div class="row ">
                            @for ($day = 1; $day < 8; $day++)
                                @php
                                    $shift1 = $workingHours
                                        ->where('day_of_week', $day)
                                        ->where('shift_number', 1)
                                        ->first();
                                    $shift2 = $workingHours
                                        ->where('day_of_week', $day)
                                        ->where('shift_number', 2)
                                        ->first();
                                @endphp

                                <div class="form-group row">
                                    <span class="col-md-3 col-form-label">
                                        <input type="checkbox" class="form-check-input me-2 day-checkbox"
                                            id="open_day_{{ $day }}" name="open_day_{{ $day }}"
                                            data-day="{{ $day }}" @checked($shift1)>
                                        <label for="open_day_{{ $day }}">{{ __('day.' . $day) }}</label>
                                    </span>

                                    {{-- Close div --}}
                                    <div id="div-close-{{ $day }}" class="col-md-9 col-sm-10"
                                        @if ($shift1) style="display: none;" @endif>
                                        <div class="input-group mb-2">
                                            <input type="text" class="text-center form-control"
                                                value="{{ __('Close') }}" disabled>
                                        </div>
                                    </div>

                                    {{-- Hours div --}}
                                    <div id="div-open-{{ $day }}" class="col-md-9 col-sm-10"
                                        @unless ($shift1) style="display: none;" @endunless>
                                        <div class="input-group mb-2">
                                            <input type="text" class="clockpicker form-control text-center"
                                                placeholder="00:00" name="open_time_1_day_{{ $day }}"
                                                value="{{ $shift1?->open_time->format('H:i') }}">
                                            <span class="input-group-text">{{ __('-') }}</span>
                                            <input type="text" class="clockpicker form-control text-center"
                                                placeholder="00:00" name="close_time_1_day_{{ $day }}"
                                                value="{{ $shift1?->close_time->format('H:i') }}">

                                            <div class="col-form-label ms-2">
                                                <a href="javascript:void(0)" class="text-info btn-add-shift"
                                                    id="btn-add-shift-{{ $day }}" data-day="{{ $day }}">
                                                    <i class="ti-plus"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <div id="second-shift-{{ $day }}" class="input-group mb-2"
                                            @if (!$shift2) style="display: none;" @endif>
                                            <input type="text" class="clockpicker form-control text-center"
                                                placeholder="00:00" name="open_time_2_day_{{ $day }}"
                                                value="{{ $shift2?->open_time->format('H:i') }}">
                                            <span class="input-group-text">{{ __('-') }}</span>
                                            <input type="text" class="clockpicker form-control text-center"
                                                placeholder="00:00" name="close_time_2_day_{{ $day }}"
                                                value="{{ $shift2?->close_time->format('H:i') }}">

                                            <div class="col-form-label ms-2">
                                                <a href="javascript:void(0)" class="text-danger btn-remove-shift"
                                                    data-day="{{ $day }}">
                                                    <i class="ti-trash"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endfor
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
                            <a href="#" class="btn btn-dark text-white">{{ __('Back') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
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

        $('.day-checkbox').change(function() {
            var day = $(this).data("day");

            if ($(this).is(':checked')) {
                $('#div-open-' + day).show();
                $('#div-close-' + day).hide();
                $('#second-shift-' + day).hide();
            } else {
                $('#div-close-' + day).show();
                $('#div-open-' + day).hide();
                $('#div-open-' + day + ' input').val('');
            }
        });

        $('.btn-add-shift').click(function() {
            var day = $(this).data("day");
            $('#second-shift-' + day).show();
        });
        $('.btn-remove-shift').click(function() {
            var day = $(this).data("day");
            $('#btn-add-shift-' + day).show();
            $('#second-shift-' + day).hide();
            $('#second-shift-' + day + ' input').val('');
        });


        $('.btn-update').click(function(event) {
            event.preventDefault();
            $(this).prop('disabled', true);

            // $('#submitForm').submit();

            Swal.fire({
                title: @json(__('Update')),
                text: @json(__('This change will automatically update the working hours of the staffs')),
                type: 'question',
                showCancelButton: true,
                confirmButtonText: @json(__('Confirm')),
                cancelButtonText: @json(__('Cancel')),
            }).then((result) => {
                if (result.value) {
                    Swal.fire({
                        title: @json(__('Updating') . ' ...'),
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        onBeforeOpen: () => {
                            Swal.showLoading()
                        },
                    });

                    $.ajax({
                        url: $('#submitForm').attr('action'),
                        type: 'POST',
                        data: $('#submitForm').serialize(),
                        dataType: 'json',
                        success: function(response) {
                            if (response.status) {
                                $('#errorMessage').html('');
                                $('#errorMessage').hide();

                                $.toast({
                                    heading: @json(__('Success')),
                                    text: @json(__('messages.update.success')),
                                    position: 'bottom-right',
                                    icon: 'success',
                                    loader: false,
                                    hideAfter: 4000,
                                });
                            } else {
                                $('#errorMessage').html(response.error);
                                $('#errorMessage').show();
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
                                Swal.close();
                                $('.btn-update').prop('disabled', false);
                        }
                    });
                } else {
                    $(this).prop('disabled', false);
                    return false;
                }
            });
        })
    </script>
@endpush
