<x-admin.layout title="Tambah Jadwal Cuti Dokter">
    {{-- Title Atas --}}
    <div class="mb-4 flex items-center justify-between">
        <h1 class="text-2xl md:text-4xl font-semibold">Tambah Jadwal Cuti Dokter</h1>
        <a href="{{ route('admin.dokter.show', $dokter->id) }}"
            class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Kembali</a>
    </div>

    {{-- Form --}}
    <form action="{{ route('admin.dokter.cuti.store', $dokter->id) }}" method="POST" class="space-y-4">
        @csrf
        {{-- Nama Dokter --}}
        <div>
            <label for="nama_dokter" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Dokter</label>
            <input type="text" name="nama_dokter" id="nama_dokter" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-100" disabled value="{{ $dokter->nama }}">
        </div>

        {{-- Tanggal Mulai --}}
        <div>
            <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-100" required>
        </div>

        {{-- Tanggal Selesai --}}
        <div>
            <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Selesai</label>
            <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-100" required>
        </div>

        {{-- Submit Button --}}
        <div>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">Simpan</button>
        </div>
    </form>
</x-admin.layout>
