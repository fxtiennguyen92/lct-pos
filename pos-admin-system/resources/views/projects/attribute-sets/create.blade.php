<x-app-layout>
    @include('project-navigation-menu')

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="w-full bg-white border border-gray-200 rounded shadow mb-6">
                <div class="bg-gray-50 divide-x divide-gray-200 rounded p-4">
                    <h5 class="text-left text-xs text-gray-500 uppercase">New Attribute Set</h5>
                </div>
                <div class="border-t border-gray-200">
                    <div class="bg-white rounded p-4">
                        <form action="{{ route('projects.product-attribute-sets.store', $project) }}" method="POST">
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
                                    max="100" min="1" step="1" value="{{ old('priority', 1) }}"
                                    required>
                                @error('priority')
                                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="pt-4 m-4 flex items-center justify-between">
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                    Create New Attribute Set
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
        </div>
    </div>
</x-app-layout>
