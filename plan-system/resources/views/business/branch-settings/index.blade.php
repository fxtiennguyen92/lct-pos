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
                    <li class="breadcrumb-item active">{{ __('Settings') }}</li>
                </ol>
            </div>
        </div>
    </div>

    <!-- Page content -->
    <form id="submitForm" method="post"
        action="{{ route('settings.update', [session('projectCode'), session('branchCode'), $branch->setting]) }}"
        enctype="multipart/form-data">
        @csrf @method('put')
        <div class="row">
            {{-- Restaurant settings --}}
            @if ($branch->project->domain == App\DomainsEnum::RESTAURANT->value)
                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-2">{{ __('branch.settings.reservation.title') }}</h4>
                            <h6 class="card-subtitle mb-4">{{ __('branch.settings.reservation.content') }}</h6>

                            {{-- Outside setting --}}
                            <div class="form-check form-switch mb-4">
                                <input type="checkbox" class="form-check-input" name="outside_flg" id="outside_flg"
                                    @checked (old('outside_flg', $branch->setting->outside_flg))>
                                <div class="ms-2">
                                    <label class="form-check-label font-normal"
                                        for="outside_flg">{{ __('branch.settings.outside_flg.title') }}</label>
                                    <div><small
                                            class="text-muted font-size-12">{{ __('branch.settings.outside_flg.content') }}</small>
                                    </div>
                                </div>
                            </div>

                            {{-- Max number client --}}
                            <h6 class="font-normal">{{ __('branch.settings.max_number_client_reservable.title') }} :</h6>
                            @error('max_number_client_reservable')
                                <small class="form-control-feedback text-danger">{{ $message }}</small>
                            @enderror
                            @error('max_number_client_reservable_2')
                                <small class="form-control-feedback text-danger">{{ $message }}</small>
                            @enderror
                            <div id="wholeDiv" class="form-group row mt-2">
                                <div class="col-md-9"></div>
                                <div class="col-md-3 @error('max_number_client_reservable') has-danger @enderror">
                                    <input class="form-control text-end" type="number" name="max_number_client_reservable"
                                        value="{{ old('max_number_client_reservable', $branch->setting->max_number_client_reservable) }}">
                                </div>
                            </div>
                            <div id="splitDiv" class="form-group row mt-2">
                                <label class="col-md-3 col-form-label">{{ __('restaurant.positions.1') }} :</label>
                                <div class="col-md-3 @error('max_number_client_reservable_1') has-danger @enderror">
                                    <input class="form-control text-end" type="number"
                                        name="max_number_client_reservable_1"
                                        value="{{ old('max_number_client_reservable_1', $branch->setting->max_number_client_reservable) }}">
                                </div>
                                <label class="col-md-3 col-form-label">{{ __('restaurant.positions.2') }} :</label>
                                <div class="col-md-3 @error('max_number_client_reservable_2') has-danger @enderror">
                                    <input class="form-control text-end" type="number"
                                        name="max_number_client_reservable_2"
                                        value="{{ old('max_number_client_reservable_2', $branch->setting->max_number_client_reservable_2) }}">
                                </div>
                            </div>

                            <div class="border-top mb-4"></div>

                            {{-- Check full with shift --}}
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" name="restaurant_full_by_shift_flg"
                                    id="restaurant_full_by_shift_flg" @checked (old('restaurant_full_by_shift_flg', $branch->setting->restaurant_full_by_shift_flg))>
                                <div class="ms-2">
                                    <label class="form-check-label font-normal"
                                        for="restaurant_full_by_shift_flg">{{ __('branch.settings.restaurant_full_by_shift_flg.title') }}</label>
                                    <div><small
                                            class="text-muted">{{ __('branch.settings.restaurant_full_by_shift_flg.content') }}</small>
                                    </div>
                                </div>
                            </div>
                            <div id="mealDurationDiv" class="row mt-2">
                                <label class="col-md-9 col-form-label">{{ __('branch.settings.restaurant_meal_duration') }}
                                    :</label>
                                <div class="col-md-3 @error('restaurant_meal_duration') has-danger @enderror">
                                    <input id="restaurant_meal_duration" class="form-control text-end" type="number"
                                        name="restaurant_meal_duration"
                                        value="{{ old('restaurant_meal_duration', $branch->setting->restaurant_meal_duration) }}">
                                </div>
                            </div>

                            <div class="border-top my-4"></div>

                            {{-- Confirm reservation --}}
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" name="confirm_reservation_flg"
                                    id="confirm_reservation_flg" @checked (old('confirm_reservation_flg', $branch->setting->confirm_reservation_flg))>
                                <div class="ms-2">
                                    <label class="form-check-label font-normal"
                                        for="confirm_reservation_flg">{{ __('branch.settings.confirm_reservation_flg.title') }}</label>
                                    <div><small
                                            class="text-muted">{{ __('branch.settings.confirm_reservation_flg.content') }}</small>
                                    </div>
                                </div>
                            </div>

                            <div class="border-top my-4"></div>

                            {{-- Slot time interval --}}
                            <div class="form-group row mt-4">
                                <label class="col-md-9 col-form-label">{{ __('branch.settings.slot_time_interval') }}
                                    :</label>
                                <div class="col-md-3 @error('slot_time_interval') has-danger @enderror">
                                    <select class="form-select" name="slot_time_interval">
                                        <option value="15" @selected(old('slot_time_interval', $branch->setting->slot_time_interval) == 15)>15 {{ __('mins') }}</option>
                                        <option value="30" @selected(old('slot_time_interval', $branch->setting->slot_time_interval) == 30)>30 {{ __('mins') }}</option>
                                        <option value="60" @selected(old('slot_time_interval', $branch->setting->slot_time_interval) == 60)>01 {{ __('hr') }}</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Max order in same time --}}
                            <div class="form-group row mt-4">
                                <label
                                    class="col-md-9 col-form-label">{{ __('branch.settings.max_number_reservable_date') }}
                                    :</label>
                                <div class="col-md-3">
                                    <select class="form-select" name="max_number_reservable_date">
                                        <option value="7" @selected(old('max_number_reservable_date', $branch->setting->max_number_reservable_date) == 7)>7 {{ __('days') }}</option>
                                        <option value="14" @selected(old('max_number_reservable_date', $branch->setting->max_number_reservable_date) == 14)>14 {{ __('days') }}</option>
                                        <option value="28" @selected(old('max_number_reservable_date', $branch->setting->max_number_reservable_date) == 28)>01 {{ __('month') }}</option>
                                    </select>
                                </div>
                            </div>



                            <div class="border-top text-end mt-4 pt-2">
                                <button type="button"
                                    class="btn-update btn btn-success text-white">{{ __('Modify') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ __('branch.settings.client.title') }}</h4>
                        <h6 class="card-subtitle mb-4">{{ __('branch.settings.client.content') }}</h6>

                        <div class="form-group form-check form-switch">
                            <input type="checkbox" class="form-check-input" name="store_client_info_flg"
                                id="store_client_info_flg" @checked (old('store_client_info_flg', $branch->setting->store_client_info_flg))>
                            <div class="ms-2">
                                <label class="form-check-label font-normal"
                                    for="store_client_info_flg">{{ __('branch.settings.store_client_info_flg.title') }}</label>
                                <div><small
                                        class="text-muted">{{ __('branch.settings.store_client_info_flg.content') }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="form-group form-check form-switch">
                            <input type="checkbox" class="form-check-input" name="require_client_phone_flg"
                                id="require_client_phone_flg" @checked (old('require_client_phone_flg', $branch->setting->require_client_phone_flg))>
                            <div class="ms-2">
                                <label class="form-check-label font-normal"
                                    for="require_client_phone_flg">{{ __('branch.settings.require_client_phone_flg.title') }}</label>
                            </div>
                        </div>
                        <div class="form-group form-check form-switch">
                            <input type="checkbox" class="form-check-input" name="confirm_client_phone_flg"
                                id="confirm_client_phone_flg" @checked (old('confirm_client_phone_flg', $branch->setting->confirm_client_phone_flg))>
                            <div class="ms-2">
                                <label class="form-check-label font-normal"
                                    for="confirm_client_phone_flg">{{ __('branch.settings.confirm_client_phone_flg.title') }}</label>
                                <div><small
                                        class="text-muted">{{ __('branch.settings.confirm_client_phone_flg.content') }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input" name="send_feedback_flg"
                                id="send_feedback_flg" @checked (old('send_feedback_flg', $branch->setting->send_feedback_flg))>
                            <div class="ms-2">
                                <label class="form-check-label font-normal"
                                    for="send_feedback_flg">{{ __('branch.settings.send_feedback_flg.title') }}</label>
                                <p class="text-muted">{{ __('branch.settings.send_feedback_flg.content') }}</label></p>
                            </div>
                            <div class="form-group @error('feedback_link') has-danger @enderror">
                                <input class="form-control" type="text" id="feedback_link" name="feedback_link"
                                    @disabled (!old('feedback_link', $branch->setting->feedback_link))
                                    value={{ old('feedback_link', $branch->setting->feedback_link) }}>
                                @error('feedback_link')
                                    <small class="form-control-feedback">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="border-top text-end mt-4 pt-2">
                            <button type="button"
                                class="btn-update btn btn-success text-white">{{ __('Modify') }}</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
@endpush

@push('css')
@endpush

@push('js')
    <script>
        @if (session('success'))
            $.toast({
                heading: "{{ __('Success') }}",
                text: "{{ session('success') }}",
                position: 'bottom-right',
                icon: 'success',
                loader: false,
                hideAfter: 4000,
            });
        @endif

        @if (old('outside_flg', $branch->setting->outside_flg))
            $('#wholeDiv').hide();
        @else
            $('#splitDiv').hide();
        @endif

        @if (old('restaurant_full_by_shift_flg', $branch->setting->restaurant_full_by_shift_flg))
            $('#mealDurationDiv').hide();
        @else
            $('#mealDurationDiv').show();
        @endif

        $(function() {
            // Outside checkbox
            $("#outside_flg").change(function() {
                if ($(this).is(":checked")) {
                    $('#splitDiv').show();
                    $('#wholeDiv').hide();
                } else {
                    $('#splitDiv').hide();
                    $('#wholeDiv').show();
                }
            });

            $("#restaurant_full_by_shift_flg").change(function() {
                if ($(this).is(":checked")) {
                    $("#restaurant_meal_duration").val('');
                    $("#mealDurationDiv").hide();
                } else {
                    $("#mealDurationDiv").show();
                }
            });

            // Feedback checkbox
            $("#send_feedback_flg").change(function() {
                if ($(this).is(":checked")) {
                    $('#feedback_link').attr('disabled', false);
                } else {
                    $('#feedback_link').attr('disabled', true);
                }
            });

            // Submit
            // Event
            $('.btn-update').on('click', function() {
                $('.btn-update').prop('disabled', true);

                Swal.fire({
                    title: @json(__('Modify')),
                    text: @json(__('Do you want to update this data ?')),
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: @json(__('Confirm')),
                    cancelButtonText: @json(__('Cancel')),
                }).then((result) => {
                    if (result.value) {
                        $('#submitForm').submit();
                    } else {
                        $('.btn-update').prop('disabled', false);
                        return false;
                    }
                });
            })

        });
    </script>
@endpush
