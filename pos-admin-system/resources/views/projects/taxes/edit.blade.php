<x-app-layout>
    @include('project-navigation-menu')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 relative rounded mb-6"
                    role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="w-full bg-white border border-gray-200 rounded shadow mb-6">
                <div class="bg-gray-50 divide-x divide-gray-200 rounded p-4">
                    <h5 class="text-left text-xs text-gray-500 uppercase">Edit Tax</h5>
                </div>
                <div class="border-t border-gray-200">
                    <div class="bg-white rounded p-4">
                        <form action="{{ route('projects.taxes.update', [$project->id, $tax->id]) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="m-4">
                                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">
                                    Title <small class="text-red-500" title="{{ __('Required') }}">*</small>
                                </label>
                                <input type="text" name="title" id="title"
                                    class="border-gray-300 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    maxlength="150" value="{{ old('title', $tax->title) }}" required>
                                @error('title')
                                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="m-4">
                                <label for="percentage" class="block text-gray-700 text-sm font-bold mb-2">
                                    Percentage <small class="text-red-500" title="{{ __('Required') }}">*</small>
                                </label>
                                <input type="number" name="percentage" id="percentage"
                                    class="border-gray-300 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    max="100" min="0" step="0.01"
                                    value="{{ number_format(old('percentage', $tax->percentage), 2) }}" required>
                                @error('percentage')
                                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="m-4">
                                <label for="priority" class="block text-gray-700 text-sm font-bold mb-2">
                                    Priority <small class="text-red-500" title="{{ __('Required') }}">*</small>
                                </label>
                                <input type="number" name="priority" id="priority"
                                    class="border-gray-300 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    max="100" min="1" step="1"
                                    value="{{ old('priority', $tax->priority) }}" required>
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
                                        <option value="{{ $status }}" @selected(old('status', $tax->status) == $status->value)>
                                            {{ $status->label() }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('status')
                                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="m-4">
                                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">
                                    Description
                                </label>
                                <input type="text" name="description" id="description"
                                    class="border-gray-300 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    maxlength="250" value="{{ old('description', $tax->description) }}">
                                @error('description')
                                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="m-4 pt-4 flex items-center justify-between">
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                    Update Tax
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
        </div>
    </div>
</x-app-layout>
