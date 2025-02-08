@extends('template.index')

@push('content')
    <!-- Bread crumb and right sidebar toggle -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">{{ __('Projects') }}</h4>
        </div>
    </div>

    <!-- Page content -->
    <div class="row">
        <div class="col-12">
            <form method="post" action="{{ route('projects.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">{{ __('New project') }}</h4>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="photo" class="form-label">{{ __('Logo') }}</label>
                                    <input type="file" id="photo" name="photo" class="dropify"
                                        data-max-file-size="3M"
                                        data-allowed-file-extensions="jpeg jpg png svg gif webp avif av1" />
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group @error('name') has-danger @enderror">
                                            <label class="form-label" for="name">{{ __('Name') }}</label>
                                            <input id="name"
                                                class="form-control @error('name') form-control-danger @enderror"
                                                type="text" maxlength="50" placeholder="{{ __('Name') }}"
                                                name="name" value="{{ old('name') }}" required>
                                            @error('name')
                                                <small class="form-control-feedback">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group @error('code') has-danger @enderror">
                                            <label class="form-label" for="code">{{ __('Code') }}</label>
                                            <input id="code"
                                                class="form-control @error('code') form-control-danger @enderror"
                                                type="text" maxlength="50" placeholder="{{ __('Code') }}"
                                                name="code" value="{{ old('code') }}" required>
                                            @error('code')
                                                <small class="form-control-feedback">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="r-panel-body">
                                        <ul id="themecolors" class="m-t-20">
                                            <li><b>With Light sidebar</b></li>
                                            <li><a href="javascript:void(0)" data-skin="skin-default" class="default-theme">1</a></li>
                                            <li><a href="javascript:void(0)" data-skin="skin-green" class="green-theme">2</a></li>
                                            <li><a href="javascript:void(0)" data-skin="skin-red" class="red-theme working">3</a></li>
                                            <li><a href="javascript:void(0)" data-skin="skin-blue" class="blue-theme">4</a></li>
                                            <li><a href="javascript:void(0)" data-skin="skin-purple" class="purple-theme">5</a></li>
                                            <li><a href="javascript:void(0)" data-skin="skin-megna" class="megna-theme">6</a></li>
                                            <li class="d-block m-t-30"><b>With Dark sidebar</b></li>
                                            <li><a href="javascript:void(0)" data-skin="skin-default-dark" class="default-dark-theme">7</a></li>
                                            <li><a href="javascript:void(0)" data-skin="skin-green-dark" class="green-dark-theme">8</a></li>
                                            <li><a href="javascript:void(0)" data-skin="skin-red-dark" class="red-dark-theme">9</a></li>
                                            <li><a href="javascript:void(0)" data-skin="skin-blue-dark" class="blue-dark-theme">10</a></li>
                                            <li><a href="javascript:void(0)" data-skin="skin-purple-dark" class="purple-dark-theme">11</a></li>
                                            <li><a href="javascript:void(0)" data-skin="skin-megna-dark" class="megna-dark-theme">12</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
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
        });
    </script>
@endpush
