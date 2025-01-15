<x-slot name="header">
    <!-- Breadcrumb -->
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li class="inline-flex items-center">
                <a href="{{ route('projects.index') }}"
                    class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                    {{ __('Projects') }}
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="rtl:rotate-180  w-3 h-3 mx-1 text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 9 4-4-4-4" />
                    </svg>
                    <h2 class="ms-1 font-semibold text-xl text-gray-800 leading-tight">
                        {{ $project->name }}
                        <small>
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-normal rounded-full text-white {{ $project->status == '1' ? 'bg-blue-500' : 'bg-gray-700' }}">
                                {{ \App\ProjectStatusEnum::from($project->status)->label() }}
                            </span>
                        </small>
                    </h2>
                </div>
            </li>
        </ol>
    </nav>
    
    <nav>
        <div class="max-w-screen-xl pt-4 mx-auto">
            <div class="flex items-center">
                <ul class="flex flex-row font-medium mt-0 space-x-8 rtl:space-x-reverse text-sm">
                    <li>
                        <x-project-nav-link href="{{ route('projects.settings', $project->id) }}" :active="request()->routeIs('projects.settings')">Settings</x-project-nav-link>
                    </li>
                    <li>
                        <x-project-nav-link href="{{ route('projects.products.index', $project->id) }}" :active="request()->routeIs('projects.products.*')">Products</x-project-nav-link>
                    </li>
                    <li>
                        <x-project-nav-link href="{{ route('projects.product-attribute-sets.index', $project->id) }}" :active="request()->routeIs('projects.product-attribute-sets.*')">Attributes</x-project-nav-link>
                    </li>
                    <li>
                        <x-project-nav-link href="{{ route('projects.product-categories.index', $project->id) }}" :active="request()->routeIs('projects.product-categories.*')">Categories</x-project-nav-link>
                    </li>
                    <li>
                        <x-project-nav-link href="{{ route('projects.taxes.index', $project->id) }}" :active="request()->routeIs('projects.taxes.*')">Taxes</x-project-nav-link>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</x-slot>
