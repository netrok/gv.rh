<table {{ $attributes->merge(['class' => 'min-w-full divide-y divide-gray-200']) }}>
    <thead class="bg-gray-50">
        {{ $thead }}
    </thead>
    <tbody class="divide-y divide-gray-100">
        {{ $tbody }}
    </tbody>
</table>
