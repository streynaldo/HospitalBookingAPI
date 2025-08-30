<x-admin.layout title="Tambah Jadwal Dokter">
    {{-- Title Atas --}}
    <div class="mb-4 flex items-center justify-between">
        <h1 class="text-2xl md:text-4xl font-semibold text-gray-900 dark:text-gray-100">Tambah Jadwal Dokter</h1>
        <a href="{{ route('admin.dokter.show', $dokter->id) }}"
            class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600">Kembali</a>
    </div>

    {{-- Form --}}
    <div class="p-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <form action="{{ route('admin.dokter.jadwal.store', $dokter->id) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="hari" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Hari</label>
                <select id="hari" name="hari" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
                    <option value="Senin">Senin</option>
                    <option value="Selasa">Selasa</option>
                    <option value="Rabu">Rabu</option>
                    <option value="Kamis">Kamis</option>
                    <option value="Jumat">Jumat</option>
                    <option value="Sabtu">Sabtu</option>
                    <option value="Minggu">Minggu</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="jam_mulai" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jam Mulai</label>
                <input type="time" id="jam_mulai" name="jam_mulai" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
            </div>
            <div class="mb-4">
                <label for="jam_selesai" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jam Selesai</label>
                <input type="time" id="jam_selesai" name="jam_selesai" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
            </div>
            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">Simpan</button>
            </div>
        </form>
    </div>
</x-admin.layout>
