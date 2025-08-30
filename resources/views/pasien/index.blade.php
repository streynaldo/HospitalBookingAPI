<x-admin.layout title="Pasien">
    {{-- Judul Atas --}}
    <div class="mb-4 flex items-center justify-between">
        <h1 class="text-2xl md:text-4xl font-semibold text-gray-900 dark:text-gray-100">Daftar Pasien</h1>
    </div>

    {{-- Tabel --}}
    <div class="hidden md:block w-full overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">Nama</th>
                        <th class="px-4 py-3">Tanggal Lahir</th>
                        <th class="px-4 py-3">Jenis Kelamin</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @foreach ($pasiens as $pasien)
                    <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-3 text-sm">{{ $pasien->nama }}</td>
                        <td class="px-4 py-3 text-sm">{{ $pasien->dob }}</td>
                        <td class="px-4 py-3 text-sm">{{ $pasien->jenis_kelamin }}</td>
                        <td class="px-4 py-3 text-sm">
                            <a href="{{ route('admin.pasien.edit', $pasien->id) }}" class="px-2 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 ml-2">Ubah</a>
                            <form action="{{ route('admin.pasien.delete', $pasien->id) }}" method="POST" class="inline">
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
            {{ $pasiens->links() }}
        </div>
    </div>

    {{-- Tampilan Kartu untuk Layar Kecil --}}
    <div class="block md:hidden">
        @foreach ($pasiens as $pasien)
        <div class="mb-4 p-4 bg-white rounded-lg shadow dark:bg-gray-800">
            <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">Nama: {{ $pasien->nama }}</p>
            <p class="text-sm text-gray-700 dark:text-gray-400">Tanggal Lahir: {{ $pasien->dob }}</p>
            <p class="text-sm text-gray-700 dark:text-gray-400">Jenis Kelamin: {{ $pasien->jenis_kelamin }}</p>
            <div class="mt-2">
                <a href="{{ route('admin.pasien.edit', $pasien->id) }}" class="px-2 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 ml-2">Ubah</a>
                <form action="{{ route('admin.pasien.delete', $pasien->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600 ml-2">Hapus</button>
                </form>
            </div>
        </div>
        @endforeach
        {{-- Pagination --}}
        <div class="mt-4">
            {{ $pasiens->links() }}
        </div>
    </div>
</x-admin.layout>
