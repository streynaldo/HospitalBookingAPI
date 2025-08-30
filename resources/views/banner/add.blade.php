<x-admin.layout title="Tambah Banner">
    <div class="mb-4">
        <h1 class="text-2xl md:text-4xl font-semibold text-gray-900 dark:text-gray-100">Tambah Banner</h1>
    </div>

    <form action="{{ route('admin.banner.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label for="gambar" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Gambar Banner</label>
            <input type="file" name="gambar" id="gambar" accept="image/*" class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 dark:border-gray-600 dark:placeholder-gray-400 dark:bg-gray-700 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Unggah gambar dengan format JPEG, PNG, atau GIF. Maksimal ukuran 2MB.</p>
            @error('gambar')
            <span class="text-sm text-red-600">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="deskripsi" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" rows="4" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:ring-blue-500 focus:border-blue-500">{{ old('deskripsi') }}</textarea>
            @error('deskripsi')
            <span class="text-sm text-red-600">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex justify-end">
            <a href="{{ route('admin.banner.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 mr-2">Batal</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
        </div>
    </form>
</x-admin.layout>
