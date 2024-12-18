<x-app-layout>
    @include('project-navigation-menu')

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 relative rounded mb-6"
                    role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @can('settings.projects.taxes.update')
                <div class="w-full bg-white border border-gray-200 rounded shadow mb-6">
                    <div class="bg-gray-50 divide-x divide-gray-200 rounded p-4">
                        <h5 class="text-left text-xs font-medium text-gray-500 uppercase">Tax Settings</h5>
                    </div>
                    <div class="border-t border-gray-200">
                        <div class="bg-white rounded p-4">
                            <form method="POST" action="{{ route('projects.taxes.settings', $project->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="m-4">
                                    <label for="default_tax" class="block text-gray-700 text-sm font-bold mb-2">Default Tax
                                        Rate</label>
                                    <select name="default_tax" id="default_tax"
                                        class="block w-full border-gray-300 rounded-md text-sm shadow focus:outline-none focus:shadow-outline">
                                        <option value="">{{ __('No tax') }}</option>
                                        @foreach ($taxes as $tax)
                                            <option
                                                value="{{ $tax->status === \App\StatusEnum::ACTIVE->value ? $tax->id : '' }}"
                                                @selected(old('default_tax', $defaultTax) == $tax->id)
                                                {{ $tax->status !== \App\StatusEnum::ACTIVE->value ? 'disabled' : '' }}>
                                                {{ $tax->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('default_tax')
                                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <label class="m-4 inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer" name="display_price_with_tax" value="1"
                                        @checked(old('display_price_with_tax', $displayPriceWithTax) == '1') />
                                    <div
                                        class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                                    </div>
                                    <span class="ms-3 text-md text-gray-900">Display product
                                        price including taxes</span>
                                </label>

                                <div class="m-4">
                                    <button type="submit"
                                        class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                        Save Settings
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endcan


            {{-- Tax List --}}
            <div class="mb-4 mt-10 flex items-center justify-between">
                <h1 class="flex-left font-semibold text-xl text-gray-800 leading-tight">Tax Management</h1>

                @can('settings.projects.taxes.create')
                    <a href="{{ route('projects.taxes.create', $project->id) }}"
                        class="flex-right bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        {{ __('Create New Tax') }}
                    </a>
                @endcan
            </div>

            @if ($taxes->count())
                @php
                    $statusColors = [
                        \App\StatusEnum::ACTIVE->value => ' bg-green-400 text-white',
                        \App\StatusEnum::DISABLE->value => ' bg-gray-500 text-white',
                    ];
                @endphp

                <div class="bg-white border border-gray-200 overflow-hidden shadow-xl rounded">
                    <table class="shadow min-w-full divide-y divide-gray-200 ">
                        <thead class="bg-gray-200">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Title</th>
                                <th
                                    class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Percentage</th>
                                <th
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Priority</th>
                                <th
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 text-sm">
                            @foreach ($taxes as $tax)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $tax->title }}
                                        @if ($defaultTax == $tax->id)
                                            <span
                                                class="ms-1 px-2 inline-flex text-xs leading-5 font-semibold rounded-full text-white bg-indigo-500">
                                                Default
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        {{ number_format($tax->percentage, 2) . ' %' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">{{ $tax->priority }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if ($tax->trashed())
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full text-white bg-red-600">
                                                Deleted
                                            </span>
                                        @else
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors[$tax->status ?? 0] }}">
                                                {{ \App\StatusEnum::from($tax->status)->label() }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        @if ($tax->trashed())
                                            @can('settings.projects.taxes.restore')
                                                <form class="inline-block"
                                                    action="{{ route('projects.taxes.restore', $tax->id) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure?');">
                                                    @csrf @method('put')
                                                    <button type="submit"
                                                        class="text-green-500 hover:text-green-700 mb-2 mr-2">Restore</button>
                                                </form>
                                            @endcan
                                        @else
                                            @can('settings.projects.taxes.update')
                                                <a href="{{ route('projects.taxes.edit', [$project->id, $tax->id]) }}"
                                                    class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                            @endcan

                                            @can('settings.projects.taxes.trash')
                                                <form class="inline-block"
                                                    action="{{ route('projects.taxes.destroy', [$project->id, $tax->id]) }}"
                                                    method="POST" onsubmit="return confirm('Are you sure?');">
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
                    {{ $taxes->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
