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

            @can('settings.projects.product-categories.create')
                <div class="mb-6">
                    <a href="{{ route('projects.product-categories.create', $project) }}"
                        class="flex-right bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        {{ __('Create New Category') }}
                    </a>
                </div>
            @endcan

            @if ($project->productCategories->count())
                @php
                    $statusColors = [
                        \App\StatusEnum::ACTIVE->value => ' bg-green-400 text-white',
                        \App\StatusEnum::DISABLE->value => ' bg-gray-500 text-white',
                    ];
                @endphp

                <div class="bg-white border border-gray-200 overflow-hidden shadow-xl rounded">
                    <table class="shadow min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-200">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
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
                            @foreach ($project->productCategories as $productCategory)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $productCategory->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $productCategory->priority }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors[$productCategory->status ?? 0] }}">
                                            {{ \App\StatusEnum::from($productCategory->status)->label() }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        @can('settings.projects.product-categories.update')
                                            <a href="{{ route('projects.product-categories.edit', [$project, $productCategory->id]) }}"
                                                class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                        @endcan

                                        @can('settings.projects.product-categories.trash')
                                            <form class="inline-block"
                                                action="{{ route('projects.product-categories.destroy', [$project, $productCategory->id]) }}"
                                                method="POST" onsubmit="return confirm('Are you sure?');">
                                                @csrf @method('delete')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-900 mb-2 mr-2">Delete</button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>

                                {{-- Sub categories 1 --}}
                                @foreach ($productCategory->children as $productCategoryChild1)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap flex items-center">
                                            <svg class="w-[17px] h-[17px] text-gray-800 dark:text-white"
                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="1.4" d="m10 16 4-4-4-4" />
                                            </svg>
                                            {{ $productCategoryChild1->name }}s
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $productCategory->priority . '.' . $productCategoryChild1->priority }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors[$productCategoryChild1->status ?? 0] }}">
                                                {{ \App\StatusEnum::from($productCategoryChild1->status)->label() }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            @can('settings.projects.product-categories.update')
                                                <a href="{{ route('projects.product-categories.edit', [$project, $productCategoryChild1->id]) }}"
                                                    class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                            @endcan

                                            @can('settings.projects.product-categories.trash')
                                                <form class="inline-block"
                                                    action="{{ route('projects.product-categories.destroy', [$project, $productCategoryChild1->id]) }}"
                                                    method="POST" onsubmit="return confirm('Are you sure?');">
                                                    @csrf @method('delete')
                                                    <button type="submit"
                                                        class="text-red-600 hover:text-red-900 mb-2 mr-2">Delete</button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>

                                    {{-- Sub categories 2 --}}
                                    @foreach ($productCategoryChild1->children as $productCategoryChild2)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap flex items-center">
                                                <svg class="w-[17px] h-[17px] text-gray-800 dark:text-white ms-4"
                                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="1.4" d="m10 16 4-4-4-4" />
                                                </svg>
                                                {{ $productCategoryChild2->name }}s
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ $productCategory->priority . '.' . $productCategoryChild1->priority . '.' . $productCategoryChild2->priority }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors[$productCategoryChild2->status ?? 0] }}">
                                                    {{ \App\StatusEnum::from($productCategoryChild2->status)->label() }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                @can('settings.projects.product-categories.update')
                                                    <a href="{{ route('projects.product-categories.edit', [$project, $productCategoryChild2->id]) }}"
                                                        class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                                @endcan

                                                @can('settings.projects.product-categories.trash')
                                                    <form class="inline-block"
                                                        action="{{ route('projects.product-categories.destroy', [$project, $productCategoryChild2->id]) }}"
                                                        method="POST" onsubmit="return confirm('Are you sure?');">
                                                        @csrf @method('delete')
                                                        <button type="submit"
                                                            class="text-red-600 hover:text-red-900 mb-2 mr-2">Delete</button>
                                                    </form>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
