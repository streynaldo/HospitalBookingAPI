<x-admin.layout title="Klinik">
    {{-- Title Atas --}}
    <div class="mb-4 flex items-center justify-between">
        <h1 class="text-2xl md:text-4xl font-semibold text-gray-900 dark:text-gray-100">Daftar Klinik</h1>
        <a href="{{ route('admin.klinik.create') }}"
            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">+ Tambah Klinik</a>
    </div>
    <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-3">
        @foreach ($kliniks as $klinik)
            <x-cards.klinik-card 
                :name="$klinik->nama" 
                :desc="$klinik->deskripsi" 
                :href="route('admin.klinik.show', $klinik->id)" 
                :iconPath="asset($klinik->icon ? 'storage/' . $klinik->icon : 'image/klinik.png')"
                color="green" 
                class="dark:bg-gray-800 dark:text-gray-100" />
        @endforeach
    </div> 
    {{-- pagination --}}
    <div class="mt-4">
        {{ $kliniks->links() }}
    </div>
</x-admin.layout>
