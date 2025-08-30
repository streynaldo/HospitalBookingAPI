<x-admin.layout title="Daftar Dokter">
    {{-- Title Atas --}}
    <div class="mb-4 flex items-center justify-between">
        <h1 class="text-2xl md:text-4xl font-semibold text-gray-900 dark:text-gray-100">Daftar Dokter</h1>
        <a href="{{ route('admin.dokter.create') }}"
            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">+ Tambah Dokter</a>
    </div>

    {{-- Filter Klinik --}}
    <div class="mb-6">
        <form action="{{ route('admin.dokter.index') }}" method="GET" id="filterForm" class="flex items-center space-x-4">
            <select name="klinik_id" id="klinik_id" class="block w-full md:w-1/3 rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-100" onchange="document.getElementById('filterForm').submit();">
                <option value="">Semua Klinik</option>
                @foreach ($kliniks as $klinik)
                    <option value="{{ $klinik->id }}" {{ request('klinik_id') == $klinik->id ? 'selected' : '' }}>
                        {{ $klinik->nama }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>

    {{-- List Dokter --}}
    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
        @forelse ($dokters as $dokter)
            <x-cards.dokter-card 
                :photo="asset($dokter->gambar ? 'storage/' . $dokter->gambar : 'image/dokter.webp')" 
                :name="$dokter->nama" 
                :specialization="$dokter->spesialis"
                :detailUrl="route('admin.dokter.show', $dokter->id)"
                :editUrl="route('admin.dokter.edit', $dokter->id)"
                :deleteUrl="route('admin.dokter.delete', $dokter->id)" />
        @empty
            <p class="text-gray-700 dark:text-gray-300">Tidak ada dokter yang ditemukan.</p>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $dokters->appends(request()->query())->links() }}
    </div>
</x-admin.layout>
