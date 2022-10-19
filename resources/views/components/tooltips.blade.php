<!-- views/components/tooltip.blade.php -->
@props(['title'])

<div class="group relative text-gray-700 dark:text-white">

    {{ $slot }}

    <div class="hidden group-hover:block absolute z-10 top-2/3 left-4 rounded px-2 py-1 text-sm ">
        {{ $title }} aaa
    </div>

    <div class="opacity-0 group-hover:opacity-100 absolute z-10 top-2/3 left-4 rounded px-2 py-1 text-sm ">
        {{ $title }} bbb
    </div>

</div>