@extends('template.index')

@push('content')
    <!-- Bread crumb and right sidebar toggle -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">{{ __('Accounts') }}</h4>
        </div>
        <div class="col-md-7 align-self-center text-end">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item">{{ __('My business') }}</li>
                    <li class="breadcrumb-item">{{ __('Human resources') }}</li>
                    <li class="breadcrumb-item active">{{ __('Accounts') }}</li>
                </ol>
            </div>
        </div>
    </div>

    <!-- Page content -->
    <form method="post" action="{{ route('project-accounts.store', session('projectCode')) }}"
        enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-8 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">{{ __('New account') }}</h4>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group @error('email') has-danger @enderror">
                                    <label class="form-label" for="email">{{ __('Email') }} <span
                                            class="text-danger">*</span></label>
                                    <input id="email" class="form-control @error('email') form-control-danger @enderror"
                                        type="email" maxlength="250" placeholder="{{ __('Email') }}" name="email"
                                        value="{{ old('email') }}" required>
                                    @error('email')
                                        <small class="form-control-feedback">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="form-group @error('name') has-danger @enderror">
                                    <label class="form-label" for="name">{{ __('Last name') }} <span
                                            class="text-danger">*</span></label>
                                    <input id="name" class="form-control @error('name') form-control-danger @enderror"
                                        type="text" maxlength="150" placeholder="{{ __('Last name') }}" name="name"
                                        value="{{ old('name') }}" required>
                                    @error('name')
                                        <small class="form-control-feedback">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="form-group @error('first_name') has-danger @enderror">
                                    <label class="form-label" for="first_name">{{ __('First name') }}</label>
                                    <input id="first_name"
                                        class="form-control @error('first_name') form-control-danger @enderror"
                                        type="text" maxlength="200" placeholder="{{ __('First name') }}"
                                        name="first_name" value="{{ old('first_name') }}">
                                    @error('first_name')
                                        <small class="form-control-feedback">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group @error('phone_number') has-danger @enderror">
                                    <label class="form-label" for="phone">{{ __('Phone number') }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="country_code">+33</span>
                                        <input id="phone" type="tel" name="phone_number"
                                            class="form-control @error('phone_number') form-control-danger @enderror"
                                            aria-label="{{ __('Phone number') }}" aria-describedby="country_code"
                                            placeholder="{{ __('Phone number') }}" value="{{ old('phone_number') }}">
                                    </div>
                                    @error('phone_number')
                                        <small class="form-control-feedback">{{ $message }}</small>
                                    @enderror
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
                                <h4 class="card-title mb-4">{{ __('Role') }} <span class="text-danger">*</span></h4>
                                <div class="form-group @error('role') has-danger @enderror">
                                    <select class="form-select" name="role">
                                        <option disabled selected>- {{ __('Role') }} -</option>
                                        @foreach (App\RolesEnum::projectRoles() as $key => $role)
                                            <option value="{{ $key }}" @selected(old('role' == $key))>
                                                {{ $role }}</option>
                                        @endforeach
                                    </select>
                                    @error('role')
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
                                    <button type="submit"
                                        class="btn btn-success me-2 text-white">{{ __('Create') }}</button>
                                    <a href="{{ route('projects.index') }}"
                                        class="btn btn-dark text-white">{{ __('Cancel') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endpush

    @push('css')
    @endpush

    @push('js')
    @endpush
