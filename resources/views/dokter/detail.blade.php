<x-admin.layout title="Detail Dokter">
    {{-- Title Atas --}}
    <div class="mb-4 flex items-center justify-between">
        <h1 class="text-2xl md:text-4xl font-semibold text-gray-900 dark:text-gray-100">Detail Dokter</h1>
        <div class="flex gap-2">
            <a href="{{ route('admin.dokter.profesional.create', $dokter->id) }}"
                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">+ Tambah Riwayat Hidup</a>
            <a href="{{ route('admin.dokter.index') }}"
                class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600">Kembali</a>
        </div>
    </div>

    {{-- Data Dokter --}}
    <div class="p-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <div class="flex flex-col md:flex-row gap-4">
            <img src="{{ asset($dokter->gambar ? 'storage/' . $dokter->gambar : 'image/dokter.webp') }}" alt="{{ $dokter->nama }}" class="w-full md:w-48 h-auto object-cover rounded-md">
            <div>
                <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">{{ $dokter->nama }}</h2>
                <p class="text-sm text-gray-700 dark:text-gray-300">Spesialis: {{ $dokter->spesialis }}</p>
                <p class="text-sm text-gray-700 dark:text-gray-300">Klinik: {{ $klinik->nama }}</p>
            </div>
        </div>
    </div>

    {{-- Jadwal Dokter --}}
    <div class="mt-6">
        <div class="flex items-center justify-between mb-2">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Jadwal Dokter</h3>
            <a href="{{ route('admin.dokter.jadwal.create', $dokter->id) }}"
                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">+ Tambah Jadwal</a>
        </div>
        <div class="p-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
            @forelse ($jadwals as $jadwal)
                <div class="flex items-center justify-between my-1">
                    <p class="text-sm text-gray-700 dark:text-gray-300">- {{ $jadwal->hari }}: {{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</p>
                    <div>
                        <a href="{{ route('admin.dokter.jadwal.edit', [$dokter->id,$jadwal->id]) }}"
                            class="px-3 py-1 text-sm bg-yellow-500 text-white rounded hover:bg-yellow-600">Edit</a>
                        <form action="{{ route('admin.dokter.jadwal.delete', [$dokter->id,$jadwal->id]) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1 text-sm bg-red-500 text-white rounded hover:bg-red-600">Delete</button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-700 dark:text-gray-300">Tidak ada jadwal yang tersedia.</p>
            @endforelse
        </div>
    </div>

    {{-- Jadwal Cuti Dokter --}}
    <div class="mt-6">
        <div class="flex items-center justify-between mb-2">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Jadwal Cuti Dokter</h3>
            <a href="{{ route('admin.dokter.cuti.create', $dokter->id) }}"
                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">+ Tambah Jadwal Cuti</a>
        </div>
        <div class="p-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
            @forelse ($cutis as $cuti)
                <div class="flex items-center justify-between my-1">
                    <p class="text-sm text-gray-700 dark:text-gray-300">- {{ $cuti->tanggal_mulai }} - {{ $cuti->tanggal_selesai }}</p>
                    <div>
                        <a href="{{ route('admin.dokter.cuti.edit', [$dokter->id, $cuti->id]) }}"
                            class="px-3 py-1 text-sm bg-yellow-500 text-white rounded hover:bg-yellow-600">Edit</a>
                        <form action="{{ route('admin.dokter.cuti.delete', [$dokter->id, $cuti->id]) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1 text-sm bg-red-500 text-white rounded hover:bg-red-600">Delete</button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-700 dark:text-gray-300">Tidak ada jadwal cuti yang tersedia.</p>
            @endforelse
        </div>
    </div>

    {{-- Riwayat Pendidikan --}}
    <div class="mt-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Riwayat Pendidikan</h3>
        <div class="p-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
            @forelse ($pendidikans as $pendidikan)
                <div class="flex items-center justify-between my-1">
                    <p class="text-sm text-gray-700 dark:text-gray-300">- {{ $pendidikan->deskripsi }} ({{ $pendidikan->tahun }})</p>
                    <div>
                        <a href="{{ route('admin.dokter.profesional.edit', $pendidikan->id) }}"
                            class="px-3 py-1 text-sm bg-yellow-500 text-white rounded hover:bg-yellow-600">Ubah</a>
                        <form action="{{ route('admin.dokter.profesional.delete', $pendidikan->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1 text-sm bg-red-500 text-white rounded hover:bg-red-600">Delete</button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-700 dark:text-gray-300">Tidak ada data pendidikan.</p>
            @endforelse
        </div>
    </div>

    {{-- Prestasi --}}
    <div class="mt-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Prestasi</h3>
        <div class="p-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
            @forelse ($prestasis as $prestasi)
                <div class="flex items-center justify-between my-1">
                    <p class="text-sm text-gray-700 dark:text-gray-300">- {{ $prestasi->deskripsi }} ({{ $prestasi->tahun }})</p>
                    <div>
                        <a href="{{ route('admin.dokter.profesional.edit', $prestasi->id) }}"
                            class="px-3 py-1 text-sm bg-yellow-500 text-white rounded hover:bg-yellow-600">Ubah</a>
                        <form action="{{ route('admin.dokter.profesional.delete', $prestasi->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1 text-sm bg-red-500 text-white rounded hover:bg-red-600">Delete</button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-700 dark:text-gray-300">Tidak ada data prestasi.</p>
            @endforelse
        </div>
    </div>

    {{-- Pengalaman Praktik --}}
    <div class="mt-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Pengalaman Praktik</h3>
        <div class="p-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
            @forelse ($pengalamans as $pengalaman)
                <div class="flex items-center justify-between my-1">
                    <p class="text-sm text-gray-700 dark:text-gray-300">- {{ $pengalaman->deskripsi }} ({{ $pengalaman->tahun }})</p>
                    <div>
                        <a href="{{ route('admin.dokter.profesional.edit', $pengalaman->id) }}"
                            class="px-3 py-1 text-sm bg-yellow-500 text-white rounded hover:bg-yellow-600">Ubah</a>
                        <form action="{{ route('admin.dokter.profesional.delete', $pengalaman->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1 text-sm bg-red-500 text-white rounded hover:bg-red-600">Delete</button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-700 dark:text-gray-300">Tidak ada data pengalaman praktik.</p>
            @endforelse
        </div>
    </div>
</x-admin.layout>
