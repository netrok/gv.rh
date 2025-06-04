<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">{{ $title }}</h1>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-between mb-4">
        <a href="{{ $routeCreate }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
            Crear {{ $entityName }}
        </a>
        <form action="{{ $routeIndex }}" method="GET" class="w-1/3">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Buscar {{ strtolower($entityName) }}..."
                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-blue-300"
            />
        </form>
    </div>

    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                {{ $thead }}
            </thead>
            <tbody class="divide-y divide-gray-200">
                {{ $tbody }}
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $items->withQueryString()->links() }}
    </div>
</div>
