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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title text-uppercase m-t-10">{{ __('Accounts') }}</h5>
                    <a href="{{ route('project-accounts.create', $project->code) }}" class="btn btn-info text-white">
                        <i class="ti-plus"></i> {{ __('Add new') }}</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-md-6">
                            <form action={{ route('project-accounts.index', $project->code) }}>
                                @csrf
                                <div class="input-group mb-3">
                                    <span class="input-group-text"><i class="ti-search"></i></span>
                                    <input type="search" class="form-control" name="search"
                                        placeholder="{{ __('Search') }}" value="{{ request()->get('search') }}">
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>{{ __('Full name') }}</th>
                                    <th>{{ __('Email') }}</th>
                                    <th>{{ __('Phone number') }}</th>
                                    <th class="text-center">{{ __('Status') }}</th>
                                    <th>{{ __('Role') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($accounts as $account)
                                    <tr class="clickable-row"
                                        data-href="{{ route('project-accounts.edit', ['projectCode' => $project->code, 'project_account' => $account]) }}">
                                        <th>{{ $account->full_name }}</th>
                                        <td>{{ $account->email }}</td>
                                        <td>{{ $account->formatted_phone_number }}</td>
                                        <td class="text-center">
                                            @if ($account->active_flg)
                                                <i class="text-success icon-check" title="{{ __('status.active') }}"></i>
                                            @else
                                                <i class="text-danger icon-close" title="{{ __('status.inactive') }}"></i>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($account->hasRole(App\RolesEnum::ADMIN))
                                                <span
                                                    class="label label-danger me-2">{{ App\RolesEnum::ADMIN->label() }}</span>
                                            @endif
                                            @if ($account->hasRole(App\RolesEnum::DIRECTOR->value))
                                                <span
                                                    class="label label-info me-2">{{ App\RolesEnum::DIRECTOR->label() }}</span>
                                            @endif
                                            @if ($account->hasRole(App\RolesEnum::MANAGER))
                                                <span
                                                    class="label label-success me-2">{{ App\RolesEnum::MANAGER->label() }}</span>
                                            @endif
                                            @if ($account->hasRole(App\RolesEnum::STAFF))
                                                <span
                                                    class="label bg-dark me-2">{{ App\RolesEnum::STAFF->label() }}</span>
                                            @endif
                                        </td>
                                    <tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div>
                            {{ $accounts->links() }}
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
