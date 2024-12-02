<x-app-layout>
    @include('project-navigation-menu')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h5 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                    {{ __('Create New Tax') }}
                </h5>
                <form action="{{ route('projects.taxes.store', $project->id) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="title" class="block text-gray-700 text-sm font-bold mb-2">
                            Title <small class="text-red-500" title="{{ __('Required') }}">*</small>
                        </label>
                        <input type="text" name="title" id="title"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            maxlength="150" value="{{ old('title') }}" required>
                        @error('title')
                            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="percentage" class="block text-gray-700 text-sm font-bold mb-2">
                            Percentage <small class="text-red-500" title="{{ __('Required') }}">*</small>
                        </label>
                        <input type="number" name="percentage" id="percentage"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            max="100" min="0" step="0.01" value="{{ old('percentage') }}" required>
                        @error('percentage')
                            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="priority" class="block text-gray-700 text-sm font-bold mb-2">
                            Priority <small class="text-red-500" title="{{ __('Required') }}">*</small>
                        </label>
                        <input type="number" name="priority" id="priority"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            max="100" min="1" step="1" value="{{ old('priority', 1) }}" required>
                        @error('priority')
                            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="status" class="block text-gray-700 text-sm font-bold mb-2">
                            Status
                        </label>
                        <select name="status" id="status"
                            class="block w-full border rounded shadow focus:outline-none focus:shadow-outline">
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

                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 text-sm font-bold mb-2">
                            Description
                        </label>
                        <input type="text" name="description" id="description"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            maxlength="250" value="{{ old('description') }}" required>
                        @error('description')
                            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Create New Tax
                        </button>
                        <a href="{{ route('projects.taxes.index', $project->id) }}"
                            class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
