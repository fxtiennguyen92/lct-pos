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

            <div class="w-full bg-white border border-gray-200 rounded shadow mb-6">
                <div class="bg-gray-50 divide-x divide-gray-200 rounded p-4">
                    <h5 class="text-left text-xs font-medium text-gray-500 uppercase">Attribute set</h5>
                </div>
                <div class="border-t border-gray-200">
                    <div class="bg-white rounded p-4">
                        <form action="{{ route('projects.product-attribute-sets.update', [$project, $productAttributeSet]) }}"
                            method="POST">
                            @csrf
                            @method('PUT')
                            <div class="m-4">
                                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">
                                    Title <small class="text-red-500" title="{{ __('Required') }}">*</small>
                                </label>
                                <input type="text" name="title" id="title"
                                    class="border-gray-300 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    maxlength="150" value="{{ old('title', $productAttributeSet->title) }}" required>
                                @error('title')
                                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="m-4">
                                <label for="priority" class="block text-gray-700 text-sm font-bold mb-2">
                                    Priority <small class="text-red-500" title="{{ __('Required') }}">*</small>
                                </label>
                                <input type="number" name="priority" id="priority"
                                    class="border-gray-300 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    max="100" min="1" step="1"
                                    value="{{ old('priority', $productAttributeSet->priority) }}" required>
                                @error('priority')
                                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="m-4">
                                <label for="status" class="block text-gray-700 text-sm font-bold mb-2">
                                    Status
                                </label>
                                <select name="status" id="status"
                                    class="block w-full border border-gray-300 rounded shadow focus:outline-none focus:shadow-outline">
                                    @foreach (\App\StatusEnum::cases() as $status)
                                        <option value="{{ $status }}" @selected(old('status', $productAttributeSet->status) == $status->value)>
                                            {{ $status->label() }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('status')
                                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="pt-4 m-4 flex items-center justify-between">
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                    Update Attribute Set
                                </button>
                                <a href="{{ route('projects.product-attribute-sets.index', $project) }}"
                                    class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Attribute list --}}
            <div class="mb-4 mt-10 flex items-center justify-between">
                <h1 class="flex-left font-semibold text-xl text-gray-800 leading-tight">Attribute List</h1>

                @can('settings.projects.product-attributes.create')
                    <a href="{{ route('projects.product-attribute-sets.product-attributes.create', [$project, $productAttributeSet]) }}"
                        class="flex-right bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        {{ __('Create New Attribute') }}
                    </a>
                @endcan
            </div>

            @if ($productAttributeSet->productAttributes->count())
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
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Priority</th>
                                <th
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Default</th>
                                <th
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 text-sm">
                            @foreach ($productAttributeSet->productAttributes as $attribute)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $attribute->title }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">{{ $attribute->priority }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if ($attribute->default_flg)
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full text-white bg-indigo-600">
                                                Default
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors[$attribute->status ?? 0] }}">
                                            {{ \App\StatusEnum::from($attribute->status)->label() }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        @can('settings.projects.product-attributes.update')
                                            <a href="{{ route('projects.product-attribute-sets.product-attributes.edit', [$project, $productAttributeSet, $attribute]) }}"
                                                class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                        @endcan

                                        @can('settings.projects.product-attributes.trash')
                                            <form class="inline-block"
                                                action="{{ route('projects.product-attribute-sets.product-attributes.destroy', [$project, $productAttributeSet, $attribute->id]) }}"
                                                method="POST" onsubmit="return confirm('Are you sure?');">
                                                @csrf @method('delete')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-900 mb-2 mr-2">Delete</button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
