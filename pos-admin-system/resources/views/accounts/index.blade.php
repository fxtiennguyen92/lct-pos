<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Accounts') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 relative rounded mb-6"
                    role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @can('settings.account.create')
                <div class="mb-6">
                    <a href="{{ route('accounts.create') }}"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        {{ __('Create new account') }}
                    </a>
                </div>
            @endcan


            <form class="max-w-md mb-4" action="{{ route('accounts.index') }}">
                @csrf
                <label for="default-search"
                    class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="search" id="default-search" name="search"
                        class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50"
                        placeholder="Search by name, email" value="{{ request()->search }}" required />
                    <button type="submit"
                        class="text-white absolute end-2.5 bottom-2.5 bg-blue-500 hover:bg-blue-700 focus:ring-4 focus:outline-none font-bold rounded text-sm py-2 px-4">
                        Search</button>
                </div>
            </form>


            @if ($accounts->count())
                @php
                    $roleColors = [
                        \App\RolesEnum::SUPER_ADMIN->value => ' bg-red-700',
                        \App\RolesEnum::ADMIN->value => ' bg-yellow-600',
                        \App\RolesEnum::CUSTOMER_SERVICE->value => ' bg-gray-800',
                        \App\RolesEnum::PROJECT_MANAGER->value => ' bg-indigo-600',
                        \App\RolesEnum::STAFF->value => ' bg-blue-500',
                    ];
                @endphp

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <table class="shadow min-w-full divide-y divide-gray-200 ">
                        <thead class="bg-gray-200">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Email</th>
                                <th
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Role</th>
                                <th
                                    class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 text-sm">
                            @foreach ($accounts as $account)
                                <tr>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap {{ $account->trashed() ? 'line-through text-gray-600' : '' }}">
                                        {{ $account->name }}</td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap {{ $account->trashed() ? 'line-through text-gray-600' : '' }}">
                                        {{ $account->email }}</td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        @foreach ($account->getRoleNames() as $roleName)
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full text-white {{ $roleColors[$roleName] }}">
                                                {{ \App\RolesEnum::from($roleName)->label() }}
                                            </span>
                                        @endforeach
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        @if (!$account->trashed())
                                            @can('settings.account.restore')
                                                <form class="inline-block"
                                                    action="{{ route('accounts.restore', $account->id) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure?');">
                                                    @csrf @method('put')
                                                    <button type="submit"
                                                        class="text-green-500 hover:text-green-700 mb-2 mr-2">Restore</button>
                                                </form>
                                            @endcan
                                        @else
                                            @can('settings.account.update')
                                                <a href="{{ route('accounts.edit', $account) }}"
                                                    class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                            @endcan


                                            @can('settings.account.trash')
                                                <form class="inline-block"
                                                    action="{{ route('accounts.destroy', $account->id) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure?');">
                                                    @csrf @method('delete')
                                                    <button type="submit"
                                                        class="text-red-600 hover:text-red-900 mb-2 mr-2">Delete</button>
                                                </form>
                                            @endcan
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="py-4">
                    {{ $accounts->links() }}
                </div>
            @else
                <p class="text-gray-500 dark:text-gray-400">No results with <b>{{ request()->search }}</b></p>
            @endif
        </div>
    </div>
</x-app-layout>
