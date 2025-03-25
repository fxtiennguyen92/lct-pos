@extends('template.index')

@push('content')
    <!-- Bread crumb and right sidebar toggle -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">{{ __('Edit project') }}</h4>
        </div>
    </div>

    <!-- Page content -->
    <form id="submitForm" method="post" action="{{ route('projects.update', $project) }}" enctype="multipart/form-data">
        @csrf @method('put')
        <div class="row">
            <div class="col-lg-8 col-md-6">
                {{-- Project --}}
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">{{ __('Project') }}</h4>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group @error('code') has-danger @enderror">
                                    <label class="form-label" for="code">{{ __('Code') }}</label>
                                    <input id="code" class="form-control @error('code') form-control-danger @enderror"
                                        type="text" maxlength="50" placeholder="{{ __('Code') }}" name="code"
                                        value="{{ old('code', $project->code) }}" disabled required>
                                    @error('code')
                                        <small class="form-control-feedback">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group @error('name') has-danger @enderror">
                                    <label class="form-label" for="name">{{ __('Name') }}</label>
                                    <input id="name" class="form-control @error('name') form-control-danger @enderror"
                                        type="text" maxlength="50" placeholder="{{ __('Name') }}" name="name"
                                        value="{{ old('name', $project->name) }}" required>
                                    @error('name')
                                        <small class="form-control-feedback">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-0 @error('domain') has-danger @enderror">
                                    <label class="form-label" for="domain">{{ __('Domain') }}</label>
                                    <select class="form-select" id="domain" name="domain">
                                        @foreach (App\DomainsEnum::values() as $domain)
                                            <option value="{{ $domain }}" @selected(old('domain', $project->domain) == $domain)>
                                                {{ __('domains.' . $domain) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('domain')
                                        <small class="form-control-feedback">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Stores --}}
                <div class="card">
                    <div class="card-header">
                        {{ __('Stores') }}
                        <div class="card-actions">
                            <a class="text-info" href="{{ route('projects.branches.index', $project) }}">
                                <i class="icon-layers"></i> {{ __('View') }}</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach ($project->branches as $branch)
                            <div class="col-lg-6 col-md-12">
                                <div class="card bg-light">
                                    @if ($branch->active_flg)
                                        <div class="ribbon ribbon-info ribbon-right" title="{{ __('status.active') }}">
                                            <i class="ti-check"></i>
                                        </div>
                                    @else
                                        <div class="ribbon ribbon-default ribbon-right" title="{{ __('status.inactive') }}">
                                            <i class="ti-lock"></i>
                                        </div>
                                    @endif
                                    <div class="card-body">
                                        <h4><a href="{{ route('projects.show', $project->code) }}"
                                            class="card-title">{{ $branch->name }}</a></h4>
                                        <p class="mb-0">{{ $branch->location }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="row">
                    {{-- Status --}}
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">{{ __('Status') }}</h4>
                                <div class="@error('status') has-danger @enderror">
                                    <select class="form-select" id="status" name="status">
                                        @foreach (App\ProjectStatusEnum::values() as $key => $status)
                                            <option value="{{ $key }}" @selected(old('status', $project->status) == $key)>
                                                {{ $status }}</option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                        <small class="form-control-feedback">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Logo --}}
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">{{ __('Logo') }}</h4>
                                <div class="@error('logo') has-danger @enderror">
                                    <input type="file" id="logo" name="logo" class="dropify"
                                        data-max-file-size="3M"
                                        data-allowed-file-extensions="jpeg jpg png svg gif webp avif av1"
                                        data-show-remove="false" data-default-file="{{ $project->logo_path }}" />

                                    @error('logo')
                                        <small class="form-control-feedback">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">{{ __('Actions') }}</h4>
                                <div>
                                    <button type="button"
                                        class="btn-update btn btn-success me-2 text-white">{{ __('Modify') }}</button>
                                    <a href="{{ route('projects.index') }}"
                                        class="btn btn-dark me-2">{{ __('Back') }}</a>
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
    <link rel="stylesheet" href="dist/css/pages/ribbon-page.css">
@endpush

@push('js')
    <script src="assets/node_modules/dropify/dist/js/dropify.min.js"></script>
    <script>
        $(document).ready(function() {
            var drEvent = $('.dropify').dropify({
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

            // Event
            $('.btn-update').on('click', function() {
                $(this).prop('disabled', true);

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
                        $(this).prop('disabled', false);
                        return false;
                    }
                });
            })
        });
    </script>
@endpush
