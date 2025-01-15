<x-app-layout>
    @include('project-navigation-menu')

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div id="alertSuccess"
                    class="flex items-center p-4 mb-4 border border-green-300 text-green-800 rounded-lg bg-green-50 rounded"
                    role="alert">
                    <div class="ms-3 text-sm font-medium">{{ session('success') }}</div>
                    <button type="button"
                        class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8"
                        data-dismiss-target="#alertSuccess" aria-label="Close">
                        <span class="sr-only">Close</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                </div>
            @endif

            @can('settings.projects.products.create')
                <div class="mb-6">
                    <a href="{{ route('projects.products.create', $project) }}"
                        class="flex-right bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        {{ __('Create New Product') }}
                    </a>
                </div>
            @endcan

            <form class="max-w-md mb-4" method="get" action="{{ route('projects.products.index', $project) }}">
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
                    <input type="search" id="default-search"
                        class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Search Products ..." name="search" value="{{ request()->search }}" />
                    <button type="submit"
                        class="text-white absolute end-2.5 bottom-2.5 bg-blue-500 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm px-4 py-2">Search</button>
                </div>
            </form>


            @if ($project->products->count())
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
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Image</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Category</th>
                                <th
                                    class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Price</th>
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
                            @foreach ($products as $product)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <figure class="max-w-lg">
                                            @if ($product->image)
                                                <img class="h-8 object-cover mx-auto rounded bg-cover"
                                                    src="{{ $product->image }}" alt="image description">
                                            @else
                                                <svg class="h-8 text-gray-400 mx-auto" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="1.5"
                                                        d="m3 16 5-7 6 6.5m6.5 2.5L16 13l-4.286 6M14 10h.01M4 19h16a1 1 0 0 0 1-1V6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Z" />
                                                </svg>
                                            @endif
                                        </figure>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $product->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap mx-auto">
                                        <span>
                                            @foreach ($product->categories as $category)
                                                {{ ($loop->first ? '' : ', ') . $category->name }}
                                            @endforeach
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        @if ($product->getPrice() > 0)
                                            <span>{{ number_format($product->sale_price, 2) . ' €' }}</span>
                                            <p class="text-red-500 line-through">
                                                {{ number_format($product->getPrice(), 2) . ' €' }}</p>
                                        @else
                                            <span>{{ number_format($product->getPrice(), 2) . ' €' }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">{{ $product->priority }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors[$product->status ?? 0] }}">
                                            {{ \App\StatusEnum::from($product->status)->label() }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        @can('settings.projects.products.update')
                                            <a href="{{ route('projects.products.edit', [$project, $product]) }}"
                                                class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                        @endcan

                                        @can('settings.projects.products.trash')
                                            <form class="inline-block"
                                                action="{{ route('projects.products.destroy', [$project, $product]) }}"
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
                <div class="py-4">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
