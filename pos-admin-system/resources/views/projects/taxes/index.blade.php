<x-app-layout>
    @include('project-navigation-menu')

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 relative rounded mb-6"
                    role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @can('settings.projects.taxes.create')
                <div class="mb-6">
                    <a href="{{ route('projects.taxes.create', $project->id) }}"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        {{ __('Create new tax') }}
                    </a>
                </div>
            @endcan

            @if ($taxes->count())
                @php
                    $statusColors = [
                        \App\StatusEnum::ACTIVE->value => ' border border-green-400 bg-green-100 text-green-700',
                        \App\StatusEnum::DISABLE->value => ' bg-gray-600 text-white',
                    ];
                @endphp

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <table class="shadow min-w-full divide-y divide-gray-200 ">
                        <thead class="bg-gray-200">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Title</th>
                                <th
                                    class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Percentage</th>
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
                            @foreach ($taxes as $tax)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $tax->title }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        {{ number_format($tax->percentage, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">{{ $tax->priority }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if ($tax->trashed())
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full text-white bg-red-600">
                                                Deleted
                                            </span>
                                        @else
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors[$tax->status ?? 0] }}">
                                                {{ \App\StatusEnum::from($tax->status)->label() }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        @if ($tax->trashed())
                                            @can('settings.projects.taxes.restore')
                                                <form class="inline-block"
                                                    action="{{ route('projects.taxes.restore', [$project->id, $tax->id]) }}"
                                                    method="POST" onsubmit="return confirm('Are you sure?');">
                                                    @csrf @method('put')
                                                    <button type="submit"
                                                        class="text-green-500 hover:text-green-700 mb-2 mr-2">Restore</button>
                                                </form>
                                            @endcan
                                        @else
                                            @can('settings.projects.taxes.update')
                                                <a href="{{ route('projects.taxes.edit', [$project->id, $tax->id]) }}"
                                                    class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                            @endcan

                                            @can('settings.projects.taxes.trash')
                                                <form class="inline-block"
                                                    action="{{ route('projects.taxes.destroy', [$project->id, $tax->id]) }}"
                                                    method="POST" onsubmit="return confirm('Are you sure?');">
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
                    {{ $taxes->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
