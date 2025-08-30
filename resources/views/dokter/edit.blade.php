<x-admin.layout title="Edit Dokter">
    {{-- Title Atas --}}
    <div class="mb-4 flex items-center justify-between">
        <h1 class="text-2xl md:text-4xl font-semibold">Edit Dokter</h1>
        <a href="{{ route('admin.dokter.index') }}"
            class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Kembali</a>
    </div>

    {{-- Form --}}
    <form action="{{ route('admin.dokter.update', $dokter->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')
        {{-- Nama --}}
        <div>
            <label for="nama" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Dokter</label>
            <input type="text" name="nama" id="nama" value="{{ $dokter->nama }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-100" required>
        </div>

        {{-- Spesialis --}}
        <div>
            <label for="spesialis" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Spesialis</label>
            <input type="text" name="spesialis" id="spesialis" value="{{ $dokter->spesialis }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-100" required>
        </div>

        {{-- Klinik --}}
        <div>
            <label for="klinik_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Klinik</label>
            <select name="klinik_id" id="klinik_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-100" required>
                <option value="">Pilih Klinik</option>
                @foreach ($kliniks as $klinik)
                    <option value="{{ $klinik->id }}" {{ $dokter->klinik_id == $klinik->id ? 'selected' : '' }}>
                        {{ $klinik->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Foto --}}
        <div>
            <label for="gambar" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Foto</label>
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m0 4v10m-6 4h12a2 2 0 002-2V7a2 2 0 00-2-2H3a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <input type="file" name="gambar" id="gambar" accept="image/*" class="ml-2 mt-1 py-2 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-100" onchange="previewImage(event, 'foto-preview')">
            </div>
            <img id="foto-preview" src="{{ asset('storage/' . $dokter->gambar) }}" class="mt-2 max-h-32 rounded-md" alt="Foto Preview">
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
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
</x-admin.layout>
