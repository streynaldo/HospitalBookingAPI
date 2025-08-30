<x-admin.layout title="Tambah Riwayat Hidup">
    {{-- Title Atas --}}
    <div class="mb-4 flex items-center justify-between">
        <h1 class="text-2xl md:text-4xl font-semibold text-gray-900 dark:text-gray-100">Tambah Riwayat Hidup</h1>
        <a href="{{ route('admin.dokter.show', $dokter->id) }}"
            class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600">Kembali</a>
    </div>

    {{-- Form --}}
    <div class="p-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <form action="{{ route('admin.dokter.profesional.store', $dokter->id) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="tipe" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipe</label>
                <select id="tipe" name="kategori_profesional_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
                    @foreach ($kategoriProfesional as $kategori)
                        <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="deskripsi" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300" placeholder="Masukkan deskripsi"></textarea>
            </div>
            <div class="mb-4">
                <label for="tahun" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tahun</label>
                <input type="number" id="tahun" name="tahun" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300" placeholder="Masukkan tahun">
            </div>
            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">Simpan</button>
            </div>
        </form>
    </div>
</x-admin.layout>
