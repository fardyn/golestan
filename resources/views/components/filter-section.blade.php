@props(['class' => ''])

<div {{ $attributes->merge(['class' => 'bg-white shadow rounded-lg p-6 mb-6 ' . $class]) }}>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        {{ $slot }}
    </div>
</div>