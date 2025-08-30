<x-admin.layout title="Banner">
    <div class="mb-4 flex items-center justify-between">
        <h1 class="text-2xl md:text-4xl font-semibold text-gray-900 dark:text-gray-100">Daftar Banner</h1>
        <a href="{{ route('admin.banner.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Tambah Banner</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach ($banners as $banner)
        <div class="bg-white rounded-lg shadow dark:bg-gray-800">
            <img src="{{ asset('storage/banners/' . $banner->gambar) }}" alt="{{ $banner->deskripsi }}" class="w-full h-48 object-cover rounded-t-lg">
            <div class="p-4">
                <p class="text-sm text-gray-700 dark:text-gray-300">{{ $banner->deskripsi }}</p>
                <form action="{{ route('admin.banner.delete', $banner->id) }}" method="POST" class="mt-4">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Hapus</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</x-admin.layout>
