<x-app-layout>
    @include('project-navigation-menu')

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
            <form action="{{ route('projects.products.update', [$project, $product]) }}" method="POST"
                enctype="multipart/form-data">
                @csrf @method('put')
                <div class="flex gap-4 mb-4">
                    <div class="w-3/4">
                        <div class="bg-white border border-gray-200 rounded shadow">
                            <div class="bg-gray-50 divide-x divide-gray-200 rounded p-4">
                                <h5 class="text-left text-xs text-gray-500 uppercase">
                                    {{ __('Edit Product') . ($product->variation_flg ? __(' - Variation') : '') }}</h5>
                            </div>
                            <div class="border-t border-gray-200">
                                <div class="bg-white rounded p-4">
                                    <div class="mb-4">
                                        <label for="name" class="block text-gray-700 text-sm font-bold mb-2">
                                            Name <small class="text-red-500" title="{{ __('Required') }}">*</small>
                                        </label>
                                        @if ($product->variation_flg)
                                            <input type="text" id="name"
                                                class="border-gray-200 bg-gray-200 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight"
                                                value="{{ old('name', $product->name) }}" disabled>
                                            <input type="hidden" name="name" value="{{ $product->name }}" />
                                        @else
                                            <input type="text" name="name" id="name"
                                                class="border-gray-200 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                                maxlength="150" value="{{ old('name', $product->name) }}" required>
                                            @error('name')
                                                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                            @enderror
                                        @endif
                                    </div>

                                    <div class="mb-4 gap-4 flex">
                                        <div class="w-1/2">
                                            <label for="code"
                                                class="block text-gray-700 text-sm font-bold mb-2">Code</label>
                                            <input type="text" name="code" id="code"
                                                class="border-gray-200 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                                maxlength="30" value="{{ old('code', $product->code) }}">
                                            @error('code')
                                                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="w-1/2">
                                            <label for="sku"
                                                class="block text-gray-700 text-sm font-bold mb-2">SKU</label>
                                            <input type="text" name="sku" id="sku"
                                                class="border-gray-200 bg-gray-200 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                                maxlength="200" value="{{ old('sku', $product->sku) }}" disabled>
                                            @error('sku')
                                                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="max-w-2xl">
                                            <label for="priority"
                                                class="block text-gray-700 text-sm font-bold mb-2">Priority</label>
                                            <input type="number" name="priority" id="priority"
                                                class="border-gray-200 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                                max="100" min="1" step="1"
                                                value="{{ old('priority', $product->priority) }}"required>
                                            @error('priority')
                                                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    @if (!$product->hasVariations())
                                        <div class="mb-4 gap-4 flex">
                                            <div class="w-1/2">
                                                <label for="price"
                                                    class="block text-gray-700 text-sm font-bold mb-2">Price</label>
                                                <input type="number" name="price" id="price"
                                                    class="border-gray-200 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                                    step="1"
                                                    value="{{ number_format(old('price', $product->price), 2) }}">
                                                @error('price')
                                                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="w-1/2">
                                                <label for="sale_price"
                                                    class="block text-gray-700 text-sm font-bold mb-2">Price
                                                    Sale</label>
                                                <input type="number" name="sale_price" id="sale_price"
                                                    class="border-gray-200 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                                    step="1"
                                                    value="{{ number_format(old('sale_price', $product->sale_price), 2) }}">
                                                @error('sale_price')
                                                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    @endif

                                    <div class="mb-4">
                                        <label for="description"
                                            class="block mb-2 text-sm font-medium text-gray-700">Description</label>
                                        <textarea id="description" name="description" rows="7"
                                            class="shadow  appearance-none block p-2.5 w-full text-gray-700 rounded border border-gray-200 focus:ring-blue-500 focus:border-blue-500">{!! old('description', $product->description) !!}</textarea>
                                        @error('description')
                                            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="">
                                        <label for="content"
                                            class="block mb-2 text-sm font-medium text-gray-700">Content</label>
                                        <textarea id="content" name="content" rows="9"
                                            class="shadow  appearance-none block p-2.5 w-full text-gray-700 rounded border border-gray-200 focus:ring-blue-500 focus:border-blue-500">{!! old('content', $product->content) !!}</textarea>
                                        @error('content')
                                            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>


                        {{-- Variations --}}
                        @if ($product->hasVariations())
                            <div class="bg-white border border-gray-200 rounded shadow mt-4">
                                <div
                                    class="bg-gray-50 divide-x divide-gray-200 rounded p-4 flex items-center justify-between">
                                    <h5 class="text-left text-xs text-gray-500 uppercase">Variations</h5>
                                    <a href=""
                                        class="px-3 py-2 text-xs bg-blue-500 hover:bg-blue-700 text-white rounded focus:ring-4 focus:outline-none focus:ring-blue-300">Add
                                        variation</a>
                                </div>
                                <div class="border-t border-gray-200">
                                    <div class="bg-white rounded p-4 text-gray-700">
                                        <table class="shadow min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-200">
                                                <tr>
                                                    <th
                                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Image</th>
                                                    @foreach ($product->withAttributeSets as $attributeSet)
                                                        <th
                                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                            {{ $attributeSet->title }}</th>
                                                    @endforeach
                                                    <th
                                                        class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Price</th>
                                                    <th
                                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Default</th>
                                                    <th
                                                        class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200 text-sm">
                                                @foreach ($product->variations as $variation)
                                                    <tr>
                                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                                            <figure class="max-w-lg">
                                                                @if ($variation->image)
                                                                    <img class="h-8 object-cover mx-auto rounded bg-cover"
                                                                        src="{{ $variation->image }}"
                                                                        alt="image description">
                                                                @else
                                                                    <svg class="h-8 text-gray-400 mx-auto"
                                                                        aria-hidden="true"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        width="24" height="24" fill="none"
                                                                        viewBox="0 0 24 24">
                                                                        <path stroke="currentColor"
                                                                            stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="1.5"
                                                                            d="m3 16 5-7 6 6.5m6.5 2.5L16 13l-4.286 6M14 10h.01M4 19h16a1 1 0 0 0 1-1V6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Z" />
                                                                    </svg>
                                                                @endif
                                                            </figure>
                                                        </td>

                                                        @foreach ($product->withAttributeSets as $attributeSet)
                                                            @foreach ($variation->withAttributes as $attribute)
                                                                @if ($attributeSet->id === $attribute->productAttributeSet->id)
                                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                                        {{ $attribute->title }}
                                                                    </td>
                                                                @endif
                                                            @endforeach
                                                        @endforeach

                                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                                            @if ($variation->price > 0)
                                                                <span>{{ number_format($variation->sale_price, 2) . ' €' }}</span>
                                                                <p class="text-red-500 line-through">
                                                                    {{ number_format($variation->price, 2) . ' €' }}
                                                                </p>
                                                            @else
                                                                <span>{{ number_format($variation->price, 2) . ' €' }}</span>
                                                            @endif
                                                        </td>

                                                        <td class="px-6 py-4">
                                                            @if ($variation->variation_default_flg)
                                                                <svg class="mx-auto w-[24px] h-[24px] text-green-600 dark:text-white"
                                                                    aria-hidden="true"
                                                                    xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" fill="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path fill-rule="evenodd"
                                                                        d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm13.707-1.293a1 1 0 0 0-1.414-1.414L11 12.586l-1.793-1.793a1 1 0 0 0-1.414 1.414l2.5 2.5a1 1 0 0 0 1.414 0l4-4Z"
                                                                        clip-rule="evenodd" />
                                                                </svg>
                                                            @endif
                                                        </td>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                            @can('settings.projects.products.update')
                                                                <a href="{{ route('projects.products.edit', [$project, $variation->id]) }}"
                                                                    class="text-indigo-600 hover:text-indigo-900 mr-3">{{ __('Edit') }}</a>
                                                            @endcan

                                                            @can('settings.projects.products.trash')
                                                                <form class="inline-block"
                                                                    action="{{ route('projects.products.destroy', [$project, $variation->id]) }}"
                                                                    method="POST"
                                                                    onsubmit="return confirm('Are you sure?');">
                                                                    @csrf @method('delete')
                                                                    <button type="submit"
                                                                        class="text-red-600 hover:text-red-900 mb-2 mr-2">{{ __('Delete') }}</button>
                                                                </form>
                                                            @endcan
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="w-1/4">
                        {{-- Actions --}}
                        <div class="bg-white border border-gray-200 rounded shadow mb-6">
                            <div class="bg-gray-50 divide-x divide-gray-200 rounded p-4">
                                <h5 class="text-left text-xs text-gray-500 uppercase">
                                    Actions</h5>
                            </div>
                            <div class="border-t border-gray-200">
                                <div class="bg-white rounded p-4 flex gap-2">
                                    <button type="submit"
                                        class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                        Update
                                    </button>

                                    <a href="{{ route('projects.products.index', $project) }}"
                                        class="inline-flex items-center justify-center py-2 px-4 text-base text-gray-500 rounded border border-gray-400 bg-gray-50 hover:text-gray-900 hover:bg-gray-100">
                                        Cancel
                                    </a>
                                </div>
                            </div>
                        </div>

                        {{-- Categories --}}
                        @if (!$product->variation_flg)
                            <div class="bg-white border border-gray-200 rounded shadow mb-6">
                                <div class="bg-gray-50 divide-x divide-gray-200 rounded p-4">
                                    <h5 class="text-left text-xs text-gray-500 uppercase">
                                        Categories</h5>
                                </div>
                                <div class="border-t border-gray-200 bg-white rounded">
                                    @error('categories')
                                        <p class="px-4 mt-4 text-red-500 text-xs italic">
                                            {{ $message }}</p>
                                    @enderror
                                    <div class="p-4 max-h-72 overflow-y-auto">
                                        @foreach ($project->productCategories()->active()->get() as $category)
                                            <div class="flex items-center mb-4">
                                                <input id="default-checkbox-{{ $category->id }}" name="categories[]"
                                                    type="checkbox" value="{{ $category->id }}"
                                                    @checked(in_array($category->id, old('categories', $product->categorieIds())))
                                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-200 rounded focus:ring-blue-500 focus:ring-2">
                                                <label for="default-checkbox-{{ $category->id }}"
                                                    class="ms-2 text-md text-gray-700">{{ $category->name }}</label>
                                            </div>

                                            @foreach ($category->children()->active()->get() as $child1)
                                                <div class="flex items-center mb-4 ps-4">
                                                    <input id="default-checkbox-{{ $child1->id }}"
                                                        name="categories[]" type="checkbox"
                                                        value="{{ $child1->id }}" @checked(in_array($child1->id, old('categories', $product->categorieIds())))
                                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-200 rounded focus:ring-blue-500 focus:ring-2">
                                                    <label for="default-checkbox-{{ $child1->id }}"
                                                        class="ms-2 text-md text-gray-700">{{ $child1->name }}</label>
                                                </div>

                                                @foreach ($child1->children()->active()->get() as $child2)
                                                    <div class="ms-4">
                                                        <div class="flex items-center mb-4 ps-4">
                                                            <input id="default-checkbox-{{ $child2->id }}"
                                                                name="categories[]" type="checkbox"
                                                                value="{{ $child2->id }}"
                                                                @checked(in_array($child2->id, old('categories', $product->categorieIds())))
                                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-200 rounded focus:ring-blue-500 focus:ring-2">
                                                            <label for="default-checkbox-{{ $child2->id }}"
                                                                class="ms-2 text-md text-gray-700">{{ $child2->name }}</label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Status --}}
                        <div class="bg-white border border-gray-200 rounded shadow mb-6">
                            <div class="bg-gray-50 divide-x divide-gray-200 rounded p-4">
                                <h5 class="text-left text-xs text-gray-500 uppercase">
                                    Status</h5>
                            </div>
                            <div class="border-t border-gray-200">
                                <div class="bg-white rounded p-4">
                                    @if ($product->variation_flg)
                                        <label class="mb-4 inline-flex items-center cursor-pointer">
                                            <input type="checkbox" class="sr-only peer" name="variation_default_flg"
                                                value="1" @checked(old('variation_default_flg', $product->variation_default_flg) == '1') />
                                            <div
                                                class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                                            </div>
                                            <span
                                                class="ms-3 text-md text-gray-900">{{ __('Default variation') }}</span>
                                        </label>
                                    @endif

                                    <select name="status" id="status"
                                        class="block mt-4 w-full border border-gray-300 rounded shadow text-sm focus:outline-none focus:shadow-outline">
                                        @foreach (\App\StatusEnum::cases() as $status)
                                            <option value="{{ $status }}" @selected(old('status', $product->status) == $status->value)>
                                                {{ $status->label() }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                        <p class="text-red-500 text-xs italic mt-2">
                                            {{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="bg-white border border-gray-200 rounded shadow mb-6">
                            <div class="bg-gray-50 divide-x divide-gray-200 rounded p-4">
                                <h5 class="text-left text-xs text-gray-500 uppercase">
                                    Image</h5>
                            </div>
                            <div class="border-t border-gray-200">
                                <div class="bg-white rounded p-4">
                                    @if ($product->image)
                                        <figure class="max-w-lg">
                                            <img class="h-auto max-w-full rounded-lg" src="{{ $product->image }}"
                                                alt="image description">
                                        </figure>
                                    @endif
                                    <input
                                        class="block w-full text-sm text-gray-700 border border-gray-200 rounded cursor-pointer bg-gray-50 focus:outline-none"
                                        id="image" name="image" type="file">

                                    @error('image')
                                        <p class="text-red-500 text-xs italic mt-2">
                                            {{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
