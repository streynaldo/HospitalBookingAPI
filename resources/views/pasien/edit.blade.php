<x-admin.layout title="Edit Pasien">
    <div class="mb-4">
        <h1 class="text-2xl md:text-4xl font-semibold text-gray-900 dark:text-gray-100">Edit Pasien</h1>
    </div>

    <form action="{{ route('admin.pasien.update', $pasien->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="nama" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama</label>
            <input type="text" name="nama" id="nama" value="{{ old('nama', $pasien->nama) }}" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:ring-blue-500 focus:border-blue-500">
            @error('nama')
            <span class="text-sm text-red-600">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="dob" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Lahir</label>
            <input type="date" name="dob" id="dob" value="{{ old('dob', $pasien->dob) }}" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:ring-blue-500 focus:border-blue-500">
            @error('dob')
            <span class="text-sm text-red-600">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jenis Kelamin</label>
            <select name="jenis_kelamin" id="jenis_kelamin" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:ring-blue-500 focus:border-blue-500">
                <option value="Laki-laki" {{ old('jenis_kelamin', $pasien->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ old('jenis_kelamin', $pasien->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>
            @error('jenis_kelamin')
            <span class="text-sm text-red-600">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex justify-end">
            <a href="{{ route('admin.pasien.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 mr-2">Batal</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
        </div>
    </form>
</x-admin.layout>
