@extends('template.index')

@push('content')
    <!-- Bread crumb and right sidebar toggle -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor"><a href="{{ route('projects.edit', $project) }}">{{ $project->name }}</a>
                | {{ __('Stores') }}
            </h4>
        </div>
        <div class="col-md-7 align-self-center text-end">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item"><a href="{{ route('projects.edit', $project) }}">{{ $project->name }}</a></li>
                    <li class="breadcrumb-item active">{{ __('Stores') }}</li>
                </ol>
            </div>
        </div>
    </div>

    <!-- Page content -->
    <div class="row">
        <div class="col-md-4">
            <form id="createForm" method="post" action="{{ route('projects.branches.store', $project) }}">
                @csrf
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">{{ __('New store') }}</h4>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group @error('code') has-danger @enderror">
                                    <label class="form-label" for="code">{{ __('Code') }} <span
                                            class="text-danger">*</span></label>
                                    <input id="code" class="form-control @error('code') form-control-danger @enderror"
                                        type="text" maxlength="50" placeholder="{{ __('Code') }}" name="code"
                                        value="{{ old('code') }}" required>
                                    @error('code')
                                        <small class="form-control-feedback">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group @error('name') has-danger @enderror">
                                    <label class="form-label" for="name">{{ __('Name') }} <span
                                            class="text-danger">*</span></label>
                                    <input id="name" class="form-control @error('name') form-control-danger @enderror"
                                        type="text" maxlength="150" placeholder="{{ __('Name') }}" name="name"
                                        value="{{ old('name') }}" required>
                                    @error('name')
                                        <small class="form-control-feedback">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group @error('location') has-danger @enderror">
                                    <label class="form-label" for="location">{{ __('Location') }}</label>
                                    <input id="location"
                                        class="form-control @error('location') form-control-danger @enderror" type="text"
                                        maxlength="350" placeholder="{{ __('Location') }}" name="location"
                                        value="{{ old('location') }}">
                                    @error('location')
                                        <small class="form-control-feedback">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 text-end">
                                <button type="button"
                                    class="btn-create btn btn-info text-white">{{ __('Create') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-8 border-start">
            @foreach ($project->branches as $branch)
                <form id="updateForm{{ $branch->id }}" method="post"
                    action="{{ route('projects.branches.update', [$project, $branch]) }}">
                    @csrf @method('put')

                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-3">{{ $branch->name }}</h4>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input id="code"
                                            class="form-control @error('code') form-control-danger @enderror" type="text"
                                            maxlength="50" placeholder="{{ __('Code') }}" name="code"
                                            value="{{ $branch->code }}" disabled required>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <input id="name"
                                            class="form-control @error('name') form-control-danger @enderror" type="text"
                                            maxlength="50" placeholder="{{ __('Name') }}" name="name"
                                            value="{{ $branch->name }}" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input class="form-control" type="text" maxlength="350"
                                            placeholder="{{ __('Location') }}" name="location"
                                            value="{{ $branch->location }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input" name="active_flg"
                                            id="activeSwitch{{ $branch->id }}" @checked ($branch->active_flg == true)>
                                        <label class="form-check-label"
                                            for="activeSwitch{{ $branch->id }}">{{ __('status.active') }}</label>
                                    </div>
                                </div>
                                <div class="col-md-6 text-end">
                                    <button type="button" data-id="{{ $branch->id }}"
                                        class="btn-update btn btn-success text-white">{{ __('Update') }}</button>
                                    <button type="button" data-id="{{ $branch->id }}"
                                        class="btn-delete btn btn-outline-danger" title="{{ __('Delete') }}"><i
                                            class="ti-trash"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            @endforeach
        </div>
    </div>

    <form id="deleteForm" method="post">
        @csrf @method('delete')
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

        @if (session('error'))
            $.toast({
                heading: "{{ __('Error') }}",
                text: "{{ session('system_error') }}",
                position: 'bottom-right',
                icon: 'error',
                loader: false,
                hideAfter: 3000,
            });
        @endif

        $(document).ready(function() {
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
                        $('#createForm').submit();
                    } else {
                        $(this).prop('disabled', false);
                        return false;
                    }
                });
            });

            $('.btn-update').on('click', function() {
                $(this).prop('disabled', true);
                var formId = '#updateForm' + $(this).data("id");

                Swal.fire({
                    title: @json(__('Modify')),
                    text: @json(__('Do you want to update this data ?')),
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: @json(__('Modify')),
                    cancelButtonText: @json(__('Cancel')),
                }).then((result) => {
                    if (result.value) {
                        $(formId).submit();
                    } else {
                        $(this).prop('disabled', false);
                        return false;
                    }
                });
            });

            $('.btn-delete').on('click', function() {
                $(this).prop('disabled', true);
                var action = @json(route('projects.branches.destroy', [$project, 'branchId']));
                action = action.replace('branchId', $(this).data("id"));

                Swal.fire({
                    title: @json(__('Delete')),
                    text: @json(__('Do you want to delete this data ?')),
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: @json(__('Delete')),
                    cancelButtonText: @json(__('Cancel')),
                }).then((result) => {
                    if (result.value) {
                        $('#deleteForm').attr('action', action);
                        $('#deleteForm').submit();
                    } else {
                        $(this).prop('disabled', false);
                        return false;
                    }
                });
            });
        });
    </script>
@endpush
