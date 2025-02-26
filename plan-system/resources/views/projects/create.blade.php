@extends('template.index')

@push('content')
    <!-- Bread crumb and right sidebar toggle -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">{{ __('Projects') }}</h4>
        </div>
    </div>

    <!-- Page content -->
    <form id="submitForm" method="post" action="{{ route('projects.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-8 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">{{ __('New project') }}</h4>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group @error('code') has-danger @enderror">
                                    <label class="form-label" for="code">{{ __('Code') }}</label>
                                    <input id="code" class="form-control @error('code') form-control-danger @enderror"
                                        type="text" maxlength="50" placeholder="{{ __('Code') }}" name="code"
                                        value="{{ old('code') }}" required>
                                    @error('code')
                                        <small class="form-control-feedback">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group @error('name') has-danger @enderror">
                                    <label class="form-label" for="name">{{ __('Name') }}</label>
                                    <input id="name" class="form-control @error('name') form-control-danger @enderror"
                                        type="text" maxlength="50" placeholder="{{ __('Name') }}" name="name"
                                        value="{{ old('name') }}" required>
                                    @error('name')
                                        <small class="form-control-feedback">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group @error('domain') has-danger @enderror">
                                    <label class="form-label" for="domain">{{ __('Domain') }}</label>
                                    <select class="form-select" id="domain" name="domain">
                                        <option disabled selected>- {{ __('Domain') }} -</option>
                                        @foreach (App\DomainsEnum::values() as $domain)
                                            <option value="{{ $domain }}" @selected(old('domain') == $domain)>
                                                {{ __('domains.' . $domain) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('domain')
                                        <small class="form-control-feedback">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="logo" class="form-label">{{ __('Logo') }}</label>
                                    <input type="file" id="logo" name="logo" class="dropify"
                                        data-max-file-size="3M"
                                        data-allowed-file-extensions="jpeg jpg png svg gif webp avif av1" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">{{ __('Status') }}</h4>
                                <div class="form-group @error('status') has-danger @enderror">
                                    <select class="form-select" id="status" disabled>
                                        @foreach (App\ProjectStatusEnum::values() as $key => $status)
                                            <option value="{{ $key }}">{{ $status }}</option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                        <small class="form-control-feedback">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">{{ __('Actions') }}</h4>
                                <div>
                                    <button type="button"
                                        class="btn-create btn btn-success me-2 text-white">{{ __('Create') }}</button>
                                    <a href="{{ route('projects.index') }}"
                                        class="btn btn-dark text-white">{{ __('Cancel') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endpush

@push('css')
    <link rel="stylesheet" href="assets/node_modules/dropify/dist/css/dropify.min.css">
@endpush

@push('js')
    <script src="assets/node_modules/dropify/dist/js/dropify.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.dropify').dropify({
                messages: {
                    default: @json(__('dropify.messages.default')),
                    replace: @json(__('dropify.messages.replace')),
                    remove: @json(__('dropify.messages.remove')),
                    error: @json(__('dropify.messages.error'))
                },
                error: {
                    fileSize: @json(__('dropify.error.fileSize')),
                    minWidth: @json(__('dropify.error.minWidth')),
                    maxWidth: @json(__('dropify.error.maxWidth')),
                    minHeight: @json(__('dropify.error.minHeight')),
                    maxHeight: @json(__('dropify.error.maxHeight')),
                    imageFormat: @json(__('dropify.error.imageFormat')),
                    fileExtension: @json(__('dropify.error.fileExtension')),
                }
            });

            // Event
            $('.btn-create').on('click', function() {
                $(this).prop('disabled', true);

                Swal.fire({
                    title: @json(__('Create')),
                    text: @json(__('Are you sure you want to create with this data ?')),
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: @json(__('Confirm')),
                    cancelButtonText: @json(__('Cancel')),
                }).then((result) => {
                    if (result.value) {
                        $('#submitForm').submit();
                    } else {
                        $(this).prop('disabled', false);
                        return false;
                    }
                });
            })
        });
    </script>
@endpush
