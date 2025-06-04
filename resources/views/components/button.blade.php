@props(['color' => 'indigo'])

<button {{ $attributes->merge([
    'class' => "inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-white hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-$color-500 bg-$color-600"
]) }}>
    {{ $slot }}
</button>
