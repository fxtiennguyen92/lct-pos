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

            @can('settings.projects.product-attributes.create')
                <div class="mb-6">
                    <a href="{{ route('projects.product-attribute-sets.create', $project) }}"
                        class="flex-right bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        {{ __('Create New Attribute Set') }}
                    </a>
                </div>
            @endcan

            @if ($project->productAttributeSets->count())
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
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Slug</th>
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
                            @foreach ($project->productAttributeSets as $productAttributeSet)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $productAttributeSet->title }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $productAttributeSet->slug }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">{{ $productAttributeSet->priority }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors[$productAttributeSet->status ?? 0] }}">
                                            {{ \App\StatusEnum::from($productAttributeSet->status)->label() }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        @can('settings.projects.product-attributes.update')
                                            <a href="{{ route('projects.product-attribute-sets.edit', [$project, $productAttributeSet]) }}"
                                                class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                        @endcan

                                        @can('settings.projects.product-attributes.trash')
                                            <form class="inline-block"
                                                action="{{ route('projects.product-attribute-sets.destroy', [$project, $productAttributeSet]) }}"
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
