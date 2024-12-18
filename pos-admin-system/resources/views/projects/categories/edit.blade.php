<x-app-layout>
    @include('project-navigation-menu')

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="w-full bg-white border border-gray-200 rounded shadow mb-6">
                <div class="bg-gray-50 divide-x divide-gray-200 rounded p-4">
                    <h5 class="text-left text-xs text-gray-500 uppercase">Product Category</h5>
                </div>
                <div class="border-t border-gray-200">
                    <div class="bg-white rounded p-4">
                        <form action="{{ route('projects.product-categories.update', [$project, $productCategory]) }}"
                            method="POST">
                            @csrf
                            @method('PUT')
                            <div class="m-4">
                                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">
                                    Name <small class="text-red-500" title="{{ __('Required') }}">*</small>
                                </label>
                                <input type="text" name="name" id="name"
                                    class="border-gray-300 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    maxlength="150" value="{{ old('name', $productCategory->name) }}" required>
                                @error('name')
                                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="m-4">
                                <label for="parent" class="block text-gray-700 text-sm font-bold mb-2">
                                    Parent
                                </label>
                                <select name="parent_id" id="parent"
                                    class="block w-full border border-gray-300 rounded shadow focus:outline-none focus:shadow-outline">

                                    <option value="">None</option>

                                    @foreach ($project->productCategories as $parentCategory)
                                        <option value="{{ $parentCategory->id }}" @selected(old('parent_id', $productCategory->parent_id) == $parentCategory->id)
                                            {{ $productCategory->id == $parentCategory->id ? 'disabled' : '' }}>
                                            {{ $parentCategory->name }}
                                        </option>
                                        @foreach ($parentCategory->children as $childCategory)
                                            <option class="ps-4" value="{{ $childCategory->id }}"
                                                @selected(old('parent_id', $productCategory->parent_id) == $childCategory->id)
                                                {{ $productCategory->id == $childCategory->id ? 'disabled' : '' }}>
                                                {!! '&nbsp;&nbsp;&nbsp' . $childCategory->name !!}
                                            </option>
                                        @endforeach
                                    @endforeach
                                </select>
                                @error('parent_id')
                                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="m-4">
                                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">
                                    Description
                                </label>
                                <textarea name="description" id="description" rows="3"
                                    class="block p-2.5 shadow appearance-none w-full text-md text-gray-900 rounded border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="">{{ old('description', $productCategory->description) }}</textarea>
                            </div>

                            <div class="m-4">
                                <label for="priority" class="block text-gray-700 text-sm font-bold mb-2">
                                    Priority <small class="text-red-500" title="{{ __('Required') }}">*</small>
                                </label>
                                <input type="number" name="priority" id="priority"
                                    class="border-gray-300 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    max="100" min="1" step="1"
                                    value="{{ old('priority', $productCategory->priority) }}" required>
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
                                        <option value="{{ $status }}" @selected(old('status', $productCategory->status) == $status->value)>
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
                                    Update Category
                                </button>
                                <a href="{{ route('projects.product-categories.index', $project) }}"
                                    class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
