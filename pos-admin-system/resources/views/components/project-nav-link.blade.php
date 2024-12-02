@props(['active'])

@php
$classes = ($active ?? false)
            ? 'items-center text-sm font-medium leading-5 text-blue-500 focus:outline-none transition duration-150 ease-in-out'
            : 'items-center text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
