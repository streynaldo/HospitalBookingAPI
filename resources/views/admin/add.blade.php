<x-admin.layout title="Tambah Pengguna">
    {{-- Judul Atas --}}
    <div class="mb-4">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">Tambah Admin</h1>
    </div>

    {{-- Form --}}
    <div class="p-4 bg-white rounded-lg shadow dark:bg-gray-800">
        <form action="{{ route('admin.admin.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="nama" class="block text-sm font-medium text-gray-700 dark:text-gray-400">Nama</label>
                <input type="text" id="nama" name="nama" value="{{ old('nama') }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-300" required>
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-400">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-300" required>
            </div>

            <div class="mb-4">
                <label for="no_telp" class="block text-sm font-medium text-gray-700 dark:text-gray-400">No. Telp</label>
                <input type="text" id="no_telp" name="no_telp" value="{{ old('no_telp') }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-300" required>
            </div>

            <div class="mb-4">
                <label for="dob" class="block text-sm font-medium text-gray-700 dark:text-gray-400">Tanggal Lahir</label>
                <input type="date" id="dob" name="dob" value="{{ old('dob') }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-300" required>
            </div>

            <div class="mb-4">
                <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 dark:text-gray-400">Jenis Kelamin</label>
                <select id="jenis_kelamin" name="jenis_kelamin" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-300" required>
                    <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-400">Password</label>
                <input type="password" id="password" name="password" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-300" required>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('admin.admin.index') }}" 
                    class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 dark:bg-gray-400 dark:hover:bg-gray-500">Batal</a>
                <button type="submit" 
                    class="ml-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">Simpan</button>
            </div>
        </form>
    </div>
</x-admin.layout>
