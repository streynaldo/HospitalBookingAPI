<x-admin.layout title="Admin">
    {{-- Judul Atas --}}
    <div class="mb-4 flex items-center justify-between">
        <h1 class="text-2xl md:text-4xl font-semibold text-gray-900 dark:text-gray-100">Daftar Admin</h1>
        <a href="{{ route('admin.admin.create') }}"
            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">+ Tambah Admin Baru</a>
    </div>

    {{-- Tabel --}}
    <div class="hidden md:block w-full overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">Nama</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">No. Telp</th>
                        <th class="px-4 py-3">Tanggal Lahir</th>
                        <th class="px-4 py-3">Jenis Kelamin</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @foreach ($users as $user)
                    <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-3 text-sm">{{ $user->nama }}</td>
                        <td class="px-4 py-3 text-sm">{{ $user->email }}</td>
                        <td class="px-4 py-3 text-sm">{{ $user->no_telp }}</td>
                        <td class="px-4 py-3 text-sm">{{ $user->dob }}</td>
                        <td class="px-4 py-3 text-sm">{{ $user->jenis_kelamin }}</td>
                        <td class="px-4 py-3 text-sm">
                            <a href="{{ route('admin.admin.edit', $user->id) }}" class="px-2 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 ml-2">Ubah</a>
                            <form action="{{ route('admin.admin.delete', $user->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600 ml-2">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{-- Pagination --}}
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>

    {{-- Tampilan Kartu untuk Layar Kecil --}}
    <div class="block md:hidden">
        @foreach ($users as $user)
        <div class="mb-4 p-4 bg-white rounded-lg shadow dark:bg-gray-800">
            <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">Nama: {{ $user->nama }}</p>
            <p class="text-sm text-gray-700 dark:text-gray-400">Email: {{ $user->email }}</p>
            <p class="text-sm text-gray-700 dark:text-gray-400">No. Telp: {{ $user->no_telp }}</p>
            <p class="text-sm text-gray-700 dark:text-gray-400">Tanggal Lahir: {{ $user->dob }}</p>
            <p class="text-sm text-gray-700 dark:text-gray-400">Jenis Kelamin: {{ $user->jenis_kelamin }}</p>
            <div class="mt-2">
                <a href="{{ route('admin.admin.edit', $user->id) }}" class="px-2 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 ml-2">Ubah</a>
                <form action="{{ route('admin.admin.delete', $user->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600 ml-2">Hapus</button>
                </form>
            </div>
        </div>
        @endforeach
        {{-- Pagination --}}
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</x-admin.layout>
