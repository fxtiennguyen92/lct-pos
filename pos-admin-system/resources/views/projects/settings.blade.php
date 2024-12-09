<x-app-layout>
    @include('project-navigation-menu')

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="w-full bg-white border border-gray-200 rounded shadow">
                <div class="bg-gray-50 divide-x divide-gray-200 rounded p-4">
                    <h5 class="text-left text-xs font-medium text-gray-500 uppercase">E-commerce</h5>
                </div>
                <div class="border-t border-gray-200">
                    <div class="bg-white rounded-lg">
                        <dl
                            class="grid max-w-screen-xl gap-4 p-4 mx-auto text-gray-900 grid-cols-4 sm:grid-cols-2">
                            
                            <div class="flex flex-col justify-center">
                                <a href="{{ route('projects.taxes.index', $project->id) }}"
                                    class="text-md font-bold text-blue-500 focus:outline-none">Taxes</a>
                                <dd class="text-sm text-gray-500">Modify your taxes settings</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
