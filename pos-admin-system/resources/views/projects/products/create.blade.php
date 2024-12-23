<x-app-layout>
    @include('project-navigation-menu')

    <div class="py-8">
        <form action="{{ route('projects.products.store', $project) }}" method="POST">
            @csrf
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex gap-4">
                <div class="w-3/4">
                    <div class="bg-white border border-gray-200 rounded shadow mb-6">
                        <div class="bg-gray-50 divide-x divide-gray-200 rounded p-4">
                            <h5 class="text-left text-xs text-gray-500 uppercase">New Product</h5>
                        </div>
                        <div class="border-t border-gray-200">
                            <div class="bg-white rounded p-4">
                                <div class="m-4">
                                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">
                                        Name <small class="text-red-500" title="{{ __('Required') }}">*</small>
                                    </label>
                                    <input type="text" name="name" id="name"
                                        class="border-gray-200 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        maxlength="150" value="{{ old('name') }}" required>
                                    @error('name')
                                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="m-4">
                                    <label for="description"
                                        class="block mb-2 text-sm font-medium text-gray-700">Description</label>
                                    <textarea id="description" rows="3"
                                        class="shadow  appearance-none block p-2.5 w-full text-gray-700 rounded border border-gray-200 focus:ring-blue-500 focus:border-blue-500">{!! old('description') !!}</textarea>
                                    @error('description')
                                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="m-4">
                                    <label for="content"
                                        class="block mb-2 text-sm font-medium text-gray-700">Content</label>
                                    <textarea id="content" rows="3"
                                        class="shadow  appearance-none block p-2.5 w-full text-gray-700 rounded border border-gray-200 focus:ring-blue-500 focus:border-blue-500">{!! old('content') !!}</textarea>
                                    @error('content')
                                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="m-4 gap-4 flex">
                                    <div class="w-1/2">
                                        <label for="code"
                                            class="block text-gray-700 text-sm font-bold mb-2">Code</label>
                                        <input type="text" name="code" id="code"
                                            class="border-gray-200 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                            maxlength="30" value="{{ old('code') }}">
                                        @error('code')
                                            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="w-1/2">
                                        <label for="sku"
                                            class="block text-gray-700 text-sm font-bold mb-2">SKU</label>
                                        <input type="text" name="sku" id="sku"
                                            class="border-gray-200 bg-gray-200 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                            maxlength="200" value="{{ old('sku') }}" disabled>
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
                                            value="{{ old('priority', 1) }}"required>
                                        @error('priority')
                                            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mx-4 gap-4 flex">
                                    <div class="w-1/2">
                                        <label for="price"
                                            class="block text-gray-700 text-sm font-bold mb-2">Price</label>
                                        <input type="number" name="price" id="price"
                                            class="border-gray-200 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                            step="1" value="{{ old('price', 0) }}">
                                        @error('price')
                                            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="w-1/2">
                                        <label for="sale_price" class="block text-gray-700 text-sm font-bold mb-2">Price
                                            Sale</label>
                                        <input type="number" name="sale_price" id="sale_price"
                                            class="border-gray-200 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                            step="1" value="{{ old('sale_price', 0) }}">
                                        @error('sale_price')
                                            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Variation --}}
                                <div class="m-4 pt-4">
                                    <label class="me-4 inline-flex items-center cursor-pointer">
                                        <input type="checkbox" class="sr-only peer" name="has_variation" value="1"
                                            @checked(old('has_variation') !== '1') />
                                        <div
                                            class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-200 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                                        </div>
                                        <span class="ms-3 text-md text-gray-900">Product has variations</span>
                                    </label>

                                    <dl class="grid max-w-screen-xl gap-4 p-4 mx-auto text-gray-700 grid-cols-2 border border-gray-200 rounded shadow">
                                        @foreach ($project->productAttributeSets as $set)
                                            <div class="flex flex-col justify-center">
                                                <span class="text-md font-bold mb-2">{{ $set->title }}</span>

                                                @foreach ($set->productAttributes as $attribute)
                                                    <div class="flex items-center ms-4">
                                                        <input id="default-checkbox" type="checkbox" value=""
                                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-200 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                        <label for="default-checkbox"
                                                            class="ms-2 text-sm font-medium">{{ $attribute->title }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endforeach
                                </div>


                                <div class="pt-4 m-4 flex items-center justify-between">
                                    <button type="submit"
                                        class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                        Create New Product
                                    </button>
                                    <a href="{{ route('projects.product-attribute-sets.index', $project) }}"
                                        class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                                        Cancel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="w-1/4">

                    {{-- Categories --}}
                    <div class="bg-white border border-gray-200 rounded shadow mb-6">
                        <div class="bg-gray-50 divide-x divide-gray-200 rounded p-4">
                            <h5 class="text-left text-xs text-gray-500 uppercase">Categories</h5>
                        </div>
                        <div class="border-t border-gray-200">
                            <div class="bg-white rounded p-4">
                                <div
                                    class="m-4 lg:overflow-auto scrollbar:!w-1.5 scrollbar:!h-1.5 scrollbar:bg-transparent scrollbar-track:!bg-slate-100 scrollbar-thumb:!rounded scrollbar-thumb:!bg-slate-300 scrollbar-track:!rounded dark:scrollbar-track:!bg-slate-500/[0.16] dark:scrollbar-thumb:!bg-slate-500/50 max-h-96 lg:supports-scrollbars:pr-2 lg:max-h-96">
                                    @foreach ($project->productCategories as $category)
                                        <div class="flex items-center mb-4">
                                            <input id="default-checkbox" type="checkbox" value=""
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-200 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="default-checkbox"
                                                class="ms-2 text-sm font-medium text-gray-700">{{ $category->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="bg-white border border-gray-200 rounded shadow mb-6">
                        <div class="bg-gray-50 divide-x divide-gray-200 rounded p-4">
                            <h5 class="text-left text-xs text-gray-500 uppercase">Tax</h5>
                        </div>
                        <div class="border-t border-gray-200">
                            <div class="bg-white rounded p-8">
                                <select name="tax_id" id="tax_id"
                                    class="block w-full border-gray-200 rounded-md text-sm shadow focus:outline-none focus:shadow-outline">
                                    <option value="">{{ __('None') }}</option>
                                    @foreach ($project->taxes()->active()->get() as $tax)
                                        <option value="{{ $tax->id }}" @selected(old('tax_id') == $tax->id)>
                                            {{ $tax->title . ' (' . $tax->percentage . '%)' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white border border-gray-200 rounded shadow mb-6">
                        <div class="bg-gray-50 divide-x divide-gray-200 rounded p-4">
                            <h5 class="text-left text-xs text-gray-500 uppercase">Status</h5>
                        </div>
                        <div class="border-t border-gray-200">
                            <div class="bg-white rounded p-8">
                                <select name="tax_id" id="tax_id"
                                    class="block w-full border-gray-200 rounded-md text-sm shadow focus:outline-none focus:shadow-outline">
                                    <option value="">{{ __('None') }}</option>
                                    @foreach ($project->taxes()->active()->get() as $tax)
                                        <option value="{{ $tax->id }}" @selected(old('tax_id') == $tax->id)>
                                            {{ $tax->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white border border-gray-200 rounded shadow mb-6">
                        <div class="bg-gray-50 divide-x divide-gray-200 rounded p-4">
                            <h5 class="text-left text-xs text-gray-500 uppercase">Image</h5>
                        </div>
                        <div class="border-t border-gray-200">
                            <div class="bg-white rounded p-8">
                                <figure class="max-w-lg">
                                    <img class="h-auto max-w-full rounded-lg"
                                        src="/docs/images/examples/image-3@2x.jpg" alt="image description">
                                    <figcaption class="mt-2 text-sm text-center text-gray-500 dark:text-gray-400">Image
                                        caption</figcaption>
                                </figure>
                                <label class="block mb-2 text-sm font-medium text-gray-700" for="image">Featured
                                    Image</label>
                                <input
                                    class="block w-full text-sm text-gray-700 border border-gray-200 rounded cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none"
                                    id="image" name="image" type="file">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
