@extends('template.index')

@push('content')
    <!-- Bread crumb and right sidebar toggle -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">{{ __('Categories') }}</h4>
        </div>
        <div class="col-md-7 align-self-center text-end">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item">{{ __('My business') }}</li>
                    <li class="breadcrumb-item">{{ __('Services') }}</li>
                    <li class="breadcrumb-item active">{{ __('Categories') }}</li>
                </ol>
            </div>
        </div>
    </div>

    <!-- Page content -->
    <form id="submitForm" method="post" action="{{ route('categories.store', session('projectCode')) }}"
        enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-8 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">{{ __('New category') }}</h4>

                        <div class="form-group @error('name') has-danger @enderror">
                            <label class="form-label" for="name">{{ __('Category name') }} <span
                                    class="text-danger">*</span></label>
                            <input id="name" class="form-control @error('name') form-control-danger @enderror"
                                type="text" maxlength="150" placeholder="{{ __('Category name') }}" name="name"
                                value="{{ old('name') }}" required>
                            @error('name')
                                <small class="form-control-feedback">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="@error('description') has-danger @enderror">
                            <label class="form-label" for="description">{{ __('Description') }}</label>
                            <textarea id="description" class="form-control @error('description') form-control-danger @enderror" rows="2"
                                maxlength="550" placeholder="{{ __('Description') }}" name="description">{!! old('description') !!}</textarea>
                            @error('description')
                                <small class="form-control-feedback">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">{{ __('Actions') }}</h4>
                            <div>
                                <button type="button"
                                    class="btn btn-submit btn-success me-2 text-white">{{ __('Create') }}</button>
                                <a href="{{ route('projects.index') }}"
                                    class="btn btn-dark text-white">{{ __('Cancel') }}</a>
                            </div>
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
        $('.btn-submit').on('click', function() {
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
    </script>
@endpush
