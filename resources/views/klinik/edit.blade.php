<x-admin.layout title="Edit Klinik">
    {{-- Title Atas --}}
    <div class="mb-4 flex items-center justify-between">
        <h1 class="text-2xl md:text-4xl font-semibold">Edit Klinik</h1>
        <a href="{{ route('admin.klinik.index') }}"
            class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Kembali</a>
    </div>

    {{-- Form --}}
    <form action="{{ route('admin.klinik.update', $klinik->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')
        {{-- Nama --}}
        <div>
            <label for="nama" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Klinik</label>
            <input type="text" name="nama" id="nama" value="{{ $klinik->nama }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-100" required>
        </div>

        {{-- Deskripsi --}}
        <div>
            <label for="deskripsi" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-100" required>{{ $klinik->deskripsi }}</textarea>
        </div>

        {{-- Icon --}}
        <div>
            <label for="icon" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Icon</label>
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828L18 9.828V7h-2.828z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 3H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V8l-5-5z" />
                </svg>
                <input type="file" name="icon" id="icon" accept="image/*" class="ml-2 mt-1 py-2 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-100" onchange="previewImage(event, 'icon-preview')">
            </div>
            <img id="icon-preview" src="{{ asset('storage/' . $klinik->icon) }}" class="mt-2 max-h-32 rounded-md" alt="Icon Preview">
        </div>

        {{-- Gambar --}}
        <div>
            <label for="gambar" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Gambar</label>
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m0 4v10m-6 4h12a2 2 0 002-2V7a2 2 0 00-2-2H3a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <input type="file" name="gambar" id="gambar" accept="image/*" class="ml-2 mt-1 py-2 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-100" onchange="previewImage(event, 'gambar-preview')">
            </div>
            <img id="gambar-preview" src="{{ asset('storage/' . $klinik->gambar) }}" class="mt-2 max-h-32 rounded-md" alt="Gambar Preview">
        </div>

        {{-- Submit Button --}}
        <div>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">Simpan Perubahan</button>
        </div>
    </form>

    {{-- Image Preview Script --}}
    <script>
        function previewImage(event, previewId) {
            const file = event.target.files[0];
            const preview = document.getElementById(previewId);
            if (file) {
                const reader = new FileReader();
                reader.onload = function () {
                    preview.src = reader.result;
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
</x-admin.layout>
