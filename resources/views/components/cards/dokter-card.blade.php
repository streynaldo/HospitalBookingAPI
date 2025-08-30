<div class="p-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
    <div class="flex flex-col md:flex-row gap-2 mb-4">
        <img src="{{ $photo }}" alt="{{ $name }}" class="w-full md:w-32 h-auto md:h-32 object-cover rounded-md">
        <div class="flex flex-col justify-end">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $name }}</h3>
            <p class="text-sm text-gray-700 dark:text-gray-300">{{ $specialization }}</p>
        </div>
    </div>
    
    @if (isset($detailUrl) || isset($editUrl) || isset($deleteUrl))
        <div class="mt-4 flex justify-start gap-2">
            @if (isset($detailUrl))
                <a href="{{ $detailUrl }}"
                    class="px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">Detail</a>
            @endif
            @if (isset($editUrl))
                <a href="{{ $editUrl }}"
                    class="px-3 py-1 bg-green-600 text-white text-sm rounded hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-600">Ubah</a>
            @endif
            @if (isset($deleteUrl))
                <form action="{{ $deleteUrl }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokter ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600">Hapus</button>
                </form>
            @endif
        </div>
    @endif
</div>
