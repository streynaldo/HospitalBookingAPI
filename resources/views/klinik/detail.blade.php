<x-admin.layout title="Klinik">
    {{-- Judul Atas --}}
    <div class="mb-4 flex flex-col md:flex-row items-center justify-between">
        <h1 class="text-2xl md:text-4xl font-semibold text-gray-900 dark:text-gray-100">Klinik {{ $klinik->nama }}</h1>
        <div class="w-full flex flex-row gap-2 justify-center md:justify-end">
            <a href="{{ route('admin.klinik.edit', $klinik->id) }}"
                class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">Ubah</a>
            <form action="{{ route('admin.klinik.delete', $klinik->id) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 ml-2">Hapus</button>
            </form>
            <a href="{{ route('admin.klinik.index') }}"
                class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600">Kembali</a>
        </div>
    </div>

    {{-- List Dokter --}}
    <div class="mt-6">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Daftar Dokter</h2>
        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($dokter as $d)
                <x-cards.dokter-card 
                    :photo="asset($d->gambar ? 'storage/' . $d->gambar : 'image/dokter.webp')" 
                    :name="$d->nama" 
                    :specialization="$d->spesialis" />
            @endforeach
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $dokter->links() }}
    </div>
</x-admin.layout>
