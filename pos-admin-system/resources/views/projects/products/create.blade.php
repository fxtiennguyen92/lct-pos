<x-app-layout>
    @include('project-navigation-menu')

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
            <form action="{{ route('projects.products.store', $project) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="flex gap-4 mb-4">
                    <div class="w-3/4">
                        <div class="bg-white border border-gray-200 rounded shadow">
                            <div class="bg-gray-50 divide-x divide-gray-200 rounded p-4">
                                <h5 class="text-left text-xs text-gray-500 uppercase">New Product</h5>
                            </div>
                            <div class="border-t border-gray-200">
                                <div class="bg-white rounded p-4">
                                    <div class="mb-4">
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

                                    <div class="mb-4 gap-4 flex">
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

                                    <div class="mb-4 gap-4 flex">
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
                                            <label for="sale_price"
                                                class="block text-gray-700 text-sm font-bold mb-2">Price
                                                Sale</label>
                                            <input type="number" name="sale_price" id="sale_price"
                                                class="border-gray-200 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                                step="1" value="{{ old('sale_price', 0) }}">
                                            @error('sale_price')
                                                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label for="description"
                                            class="block mb-2 text-sm font-medium text-gray-700">Description</label>
                                        <textarea id="description" name="description" rows="7"
                                            class="shadow  appearance-none block p-2.5 w-full text-gray-700 rounded border border-gray-200 focus:ring-blue-500 focus:border-blue-500">{!! old('description') !!}</textarea>
                                        @error('description')
                                            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="">
                                        <label for="content"
                                            class="block mb-2 text-sm font-medium text-gray-700">Content</label>
                                        <textarea id="content" name="content" rows="9"
                                            class="shadow  appearance-none block p-2.5 w-full text-gray-700 rounded border border-gray-200 focus:ring-blue-500 focus:border-blue-500">{!! old('content') !!}</textarea>
                                        @error('content')
                                            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="w-1/4">

                        {{-- Actions --}}
                        <div class="bg-white border border-gray-200 rounded shadow mb-6">
                            <div class="bg-gray-50 divide-x divide-gray-200 rounded p-4">
                                <h5 class="text-left text-xs text-gray-500 uppercase">Actions</h5>
                            </div>
                            <div class="border-t border-gray-200">
                                <div class="bg-white rounded p-4 flex gap-2">
                                    <button type="submit"
                                        class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                        Create
                                    </button>

                                    <a href="{{ route('projects.products.index', $project) }}"
                                        class="inline-flex items-center justify-center py-2 px-4 text-base text-gray-500 rounded border border-gray-400 bg-gray-50 hover:text-gray-900 hover:bg-gray-100">
                                        Cancel
                                    </a>
                                </div>
                            </div>
                        </div>

                        {{-- Categories --}}
                        <div class="bg-white border border-gray-200 rounded shadow mb-6">
                            <div class="bg-gray-50 divide-x divide-gray-200 rounded p-4">
                                <h5 class="text-left text-xs text-gray-500 uppercase">Categories</h5>
                            </div>
                            <div class="border-t border-gray-200 bg-white rounded">
                                @error('categories')
                                    <p class="px-4 mt-4 text-red-500 text-xs italic">{{ $message }}</p>
                                @enderror
                                <div class="p-4 max-h-72 overflow-y-auto">
                                    @foreach ($project->productCategories()->active()->get() as $category)
                                        <div class="flex items-center mb-4">
                                            <input id="default-checkbox-{{ $category->id }}" name="categories[]"
                                                type="checkbox" value="{{ $category->id }}"
                                                @checked(in_array($category->id, old('categories', [])))
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-200 rounded focus:ring-blue-500 focus:ring-2">
                                            <label for="default-checkbox-{{ $category->id }}"
                                                class="ms-2 text-md text-gray-700">{{ $category->name }}</label>
                                        </div>

                                        @foreach ($category->children()->active()->get() as $child1)
                                            <div class="flex items-center mb-4 ps-4">
                                                <input id="default-checkbox-{{ $child1->id }}" name="categories[]"
                                                    type="checkbox" value="{{ $child1->id }}"
                                                    @checked(in_array($child1->id, old('categories', [])))
                                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-200 rounded focus:ring-blue-500 focus:ring-2">
                                                <label for="default-checkbox-{{ $child1->id }}"
                                                    class="ms-2 text-md text-gray-700">{{ $child1->name }}</label>
                                            </div>

                                            @foreach ($child1->children()->active()->get() as $child2)
                                                <div class="ms-4">
                                                    <div class="flex items-center mb-4 ps-4">
                                                        <input id="default-checkbox-{{ $child2->id }}"
                                                            name="categories[]" type="checkbox"
                                                            value="{{ $child2->id }}" @checked(in_array($child2->id, old('categories', [])))
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

                        {{-- Status --}}
                        <div class="bg-white border border-gray-200 rounded shadow mb-6">
                            <div class="bg-gray-50 divide-x divide-gray-200 rounded p-4">
                                <h5 class="text-left text-xs text-gray-500 uppercase">Status</h5>
                            </div>
                            <div class="border-t border-gray-200">
                                <div class="bg-white rounded p-4">
                                    <select name="status" id="status"
                                        class="block w-full border border-gray-300 rounded shadow text-sm focus:outline-none focus:shadow-outline">
                                        @foreach (\App\StatusEnum::cases() as $status)
                                            <option value="{{ $status }}" @selected(old('status') == $status->value)>
                                                {{ $status->label() }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('status')
                                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="bg-white border border-gray-200 rounded shadow mb-6">
                            <div class="bg-gray-50 divide-x divide-gray-200 rounded p-4">
                                <h5 class="text-left text-xs text-gray-500 uppercase">Image</h5>
                            </div>
                            <div class="border-t border-gray-200">
                                <div class="bg-white rounded p-4">
                                    {{-- <figure class="max-w-lg">
                                    <img class="h-auto max-w-full rounded-lg"
                                        src="" alt="image description">
                                    <figcaption class="mt-2 text-sm text-center text-gray-500">Image
                                        caption</figcaption>
                                </figure> --}}
                                    <input
                                        class="block w-full text-sm text-gray-700 border border-gray-200 rounded cursor-pointer bg-gray-50 focus:outline-none"
                                        id="image" name="image" type="file">

                                    @error('image')
                                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="bg-white border border-gray-200 rounded shadow">
                    <div class="bg-gray-50 divide-x divide-gray-200 rounded p-4">
                        <h5 class="text-left text-xs text-gray-500 uppercase">Variations</h5>
                    </div>
                    <div class="border-t border-gray-200">
                        <div class="bg-white rounded px-4 pb-4 text-gray-700">
                            @error('variations')
                                <p class="text-red-500 text-xs italic mt-4">{{ $message }}</p>
                            @enderror
                            @foreach ($project->productAttributeSets()->active()->get() as $set)
                                <div class="w-full p-4 mt-4 border border-gray-200 rounded">
                                    <h3 class="mb-4 font-semibold ">{{ $set->title }}</h3>

                                    <ul class="grid w-full gap-4 md:grid-cols-3">
                                        @foreach ($set->productAttributes()->active()->get() as $attribute)
                                            <li>
                                                <div class="flex items-center me-4">
                                                    <input id="inline-checkbox-{{ $attribute->id }}" type="checkbox"
                                                        name="variations[]" value="{{ $attribute->id }}"
                                                        @checked(in_array($attribute->id, old('variations', [])))
                                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                                    <label for="inline-checkbox-{{ $attribute->id }}"
                                                        class="ms-2 text-sm">{{ $attribute->title }}</label>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
