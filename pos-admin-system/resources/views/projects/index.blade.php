<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Projects') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 relative rounded mb-6"
                    role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @can('settings.project.create')
                <div class="mb-6">
                    <a href="{{ route('projects.create') }}"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        {{ __('Create new project') }}
                    </a>
                </div>
            @endcan

            @if ($projects->count())
                @php
                    $statusColors = [
                        \App\ProjectStatusEnum::PENDING->value => ' bg-yellow-300',
                        \App\ProjectStatusEnum::ACTIVE->value => ' bg-green-400',
                        \App\ProjectStatusEnum::DISABLE->value => ' bg-gray-500',
                    ];
                @endphp

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <table class="shadow min-w-full divide-y divide-gray-200 ">
                        <thead class="bg-gray-200">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name</th>
                                <th
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Accounts</th>
                                <th
                                    class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 text-sm">
                            @foreach ($projects as $project)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $project->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if ($project->trashed())
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full text-white bg-red-600">
                                                Trashed
                                            </span>
                                        @else
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full text-white {{ $statusColors[$project->status] }}">
                                                {{ \App\ProjectStatusEnum::from($project->status)->label() }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap">{{ $project->users->count() }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        @if ($project->trashed())
                                            @can('settings.project.restore')
                                                <form class="inline-block"
                                                    action="{{ route('projects.restore', $project->id) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure?');">
                                                    @csrf @method('put')
                                                    <button type="submit"
                                                        class="text-green-500 hover:text-green-700 mb-2 mr-2">Restore</button>
                                                </form>
                                            @endcan
                                        @else
                                            @can('settings.project.update')
                                                <a href="{{ route('projects.settings', $project) }}"
                                                    class="text-purple-800 hover:text-purple-900 mr-3">Settings</a>
                                                <a href="{{ route('projects.edit', $project) }}"
                                                    class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                            @endcan

                                            @can('settings.project.trash')
                                                <form class="inline-block"
                                                    action="{{ route('projects.destroy', $project->id) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure?');">
                                                    @csrf @method('delete')
                                                    <button type="submit"
                                                        class="text-red-600 hover:text-red-900 mb-2 mr-2">Delete</button>
                                                </form>
                                            @endcan
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="py-4">
                    {{ $projects->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
