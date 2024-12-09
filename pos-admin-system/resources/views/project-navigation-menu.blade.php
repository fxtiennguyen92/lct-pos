<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $project->name }}
        <small>
            <span
                class="px-2 inline-flex text-xs leading-5 font-normal rounded-full text-white {{ $project->status == '1' ? 'bg-blue-500' : 'bg-gray-700' }}">
                {{ \App\ProjectStatusEnum::from($project->status)->label() }}
            </span>
        </small>
    </h2>
    <nav>
        <div class="max-w-screen-xl pt-4 mx-auto">
            <div class="flex items-center">
                <ul class="flex flex-row font-medium mt-0 space-x-8 rtl:space-x-reverse text-sm">
                    <li>
                        <x-project-nav-link href="{{ route('projects.settings', $project->id) }}" :active="request()->routeIs('projects.settings')">Settings</x-project-nav-link>
                    </li>
                    <li>
                        <x-project-nav-link href="{{ route('projects.taxes.index', $project->id) }}" :active="request()->routeIs('projects.taxes.*')">Taxes</x-project-nav-link>
                    </li>
                    
                </ul>
            </div>
        </div>
    </nav>
</x-slot>
