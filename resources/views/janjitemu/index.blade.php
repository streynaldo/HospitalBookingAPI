<x-admin.layout title="Janji Temu">
    {{-- Judul Atas --}}
    <div class="mb-4 flex items-center justify-between">
        <h1 class="text-2xl md:text-4xl font-semibold text-gray-900 dark:text-gray-100">Daftar Janji Temu</h1>
    </div>

    {{-- Tabel --}}
    <div class="w-full overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">Nama Pasien</th>
                        <th class="px-4 py-3">Dokter</th>
                        <th class="px-4 py-3">Tanggal Kedatangan</th>
                        <th class="px-4 py-3">Slot Waktu</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @foreach ($janjiTemus as $janjitemu)
                    <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-3 text-sm">{{ $janjitemu->pasien->nama }}</td>
                        <td class="px-4 py-3 text-sm">{{ $janjitemu->dokter->nama }}</td>
                        <td class="px-4 py-3 text-sm">{{ $janjitemu->tanggal }}</td>
                        <td class="px-4 py-3 text-sm">{{ $janjitemu->slot->slot_mulai }} - {{ $janjitemu->slot->slot_selesai }}</td>
                        <td class="px-4 py-3 text-sm">
                            {{-- <a href="{{ route('admin.janjitemu.edit', $janjitemu->id) }}" class="px-2 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 ml-2">Ubah</a> --}}
                            <form action="{{ route('admin.janjitemu.delete', $janjitemu->id) }}" method="POST" class="inline">
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
            {{ $janjiTemus->links() }}
        </div>
    </div>
</x-admin.layout>
