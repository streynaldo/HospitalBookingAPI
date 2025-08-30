@props(['title' => 'Admin'])

<!DOCTYPE html>
<html lang="en" x-data="{ dark: localStorage.getItem('dark') === 'true', sidebarOpen: false }" x-init="$watch('dark', v => localStorage.setItem('dark', v))" :class="{ 'dark': dark }" class="h-full">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-screen bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100">

    {{-- Header --}}
    <x-admin.header class="z-50" style="--header-h:56px" />

    {{-- GRID UTAMA --}}
    <div class="grid grid-cols-1 lg:grid-cols-[260px_1fr] min-h-[calc(100vh-var(--header-h))]">

        {{-- SIDEBAR --}}
        <aside class="relative" x-cloak>
            {{-- Overlay mobile --}}
            <div class="fixed inset-0 z-40 bg-black/30 lg:hidden" x-show="sidebarOpen" x-transition.opacity
                @click="sidebarOpen=false">
            </div>

            <div class="fixed z-40 left-0 top-[var(--header-h)] w-64
             bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700
             transform transition-transform duration-200 ease-out
             lg:translate-x-0 lg:static lg:top-auto lg:bottom-auto
             lg:h-[calc(100vh-var(--header-h))]"
                :class="{
                    'translate-x-0': sidebarOpen,
                    '-translate-x-full': !sidebarOpen
                }"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="-translate-x-full opacity-0"
                x-transition:enter-end="translate-x-0 opacity-100" x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="translate-x-0 opacity-100"
                x-transition:leave-end="-translate-x-full opacity-0">
                <div class="h-full lg:h-screen p-4 overflow-y-auto">
                    <x-admin.sidebar />
                </div>
            </div>
        </aside>


        {{-- MAIN --}}
        <main class="flex flex-col h-screen p-4 lg:p-6">
            <div class="flex-1">
                {{ $slot }}
            </div>
            <x-admin.footer />
        </main>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>

</html>
