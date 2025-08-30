@props([
    'name' => 'Ortopedi & Traumatology',
    'desc' => 'Spesialis Tulang',
    'href' => '#',
    // variant warna ikon & tombol: purple|blue|green|red|orange
    'color' => 'purple',
    // optional: path d untuk ikon SVG kustom
    'iconPath' => null,
])

@php
    $variants = [
        'purple' => [
            'icon' => 'text-purple-600 bg-purple-100 dark:text-purple-100 dark:bg-purple-600',
            'btn' => 'bg-purple-600 hover:bg-purple-700 focus:shadow-outline-purple',
        ],
        'blue' => [
            'icon' => 'text-blue-600 bg-blue-100 dark:text-blue-100 dark:bg-blue-600',
            'btn' => 'bg-blue-600 hover:bg-blue-700 focus:shadow-outline-blue',
        ],
        'green' => [
            'icon' => 'text-green-600 bg-green-100 dark:text-green-100 dark:bg-green-600',
            'btn' => 'bg-green-600 hover:bg-green-700 focus:shadow-outline-green',
        ],
        'red' => [
            'icon' => 'text-red-600 bg-red-100 dark:text-red-100 dark:bg-red-600',
            'btn' => 'bg-red-600 hover:bg-red-700 focus:shadow-outline-red',
        ],
        'orange' => [
            'icon' => 'text-orange-600 bg-orange-100 dark:text-orange-100 dark:bg-orange-600',
            'btn' => 'bg-orange-600 hover:bg-orange-700 focus:shadow-outline-orange',
        ],
    ];
    $v = $variants[$color] ?? $variants['purple'];
@endphp

<div class="p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
    <div class="flex items-start">
        {{-- Icon bulat --}}
        @if ($iconPath)
        <div class=" mr-4 rounded-full">
            <img src="{{ $iconPath }}" alt="ikon klinik" class="w-12 h-12">
        </div>
        @else
            <div class="p-3 mr-4 rounded-full {{ $v['icon'] }}">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                    {{-- Default ikon medical (+) dalam lingkaran --}}
                    <path
                        d="M10 1.75a8.25 8.25 0 1 0 0 16.5 8.25 8.25 0 0 0 0-16.5ZM9 9V5.75h2V9h3.25v2H11v3.25H9V11H5.75V9H9Z" />
                </svg>
            </div>
        @endif

        <div class="flex-1 min-w-0">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 leading-snug">
                {{ $name }}
            </h3>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ $desc }}
            </p>

            <div class="mt-4">
                <a href="{{ $href }}"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 border border-transparent rounded-lg active:scale-[0.99] focus:outline-none {{ $v['btn'] }}">
                    Detail Klinik
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                        aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>
