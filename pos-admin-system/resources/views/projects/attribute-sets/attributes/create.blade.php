<x-app-layout>
    @include('project-navigation-menu')

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="w-full bg-white border border-gray-200 rounded shadow mb-6">
                <div class="bg-gray-50 divide-x divide-gray-200 rounded p-4">
                    <h5 class="text-left text-xs font-medium text-gray-500 uppercase">New Attribute</h5>
                </div>
                <div class="border-t border-gray-200">
                    <div class="bg-white rounded p-4">
                        <form action="{{ route('projects.product-attribute-sets.product-attributes.store', [$project, $productAttributeSet]) }}" method="POST">
                            @csrf
                            <div class="m-4">
                                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">
                                    Title <small class="text-red-500" title="{{ __('Required') }}">*</small>
                                </label>
                                <input type="text" name="title" id="title"
                                    class="border-gray-300 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    maxlength="150" value="{{ old('title') }}" required>
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
                                    max="100" min="1" step="1" value="{{ old('priority', 1) }}" required>
                                @error('priority')
                                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <label class="m-4 inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer" name="default_flg" value="1"
                                    @checked(old('default_flg') == '1') />
                                <div
                                    class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                                </div>
                                <span class="ms-3 text-md text-gray-900">Is default ?</span>
                            </label>

                            <div class="m-4 flex items-center justify-between">
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                    Create New Attribute
                                </button>
                                <a href="{{ route('projects.product-attribute-sets.edit', [$project, $productAttributeSet]) }}"
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
