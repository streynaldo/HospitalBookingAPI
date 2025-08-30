<header
    class="sticky top-0 z-30 w-full bg-white/80 dark:bg-gray-800/80 backdrop-blur border-b border-gray-200 dark:border-gray-700">
    <div class="mx-auto max-w-7xl px-4 py-3 flex items-center gap-3">
        <button class="md:hidden p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700" @click="sidebarOpen = true"
            aria-label="Open sidebar">☰</button>

        <a href="{{ route('admin.dashboard') }}" class="font-semibold">Ciputra Hospital • Admin</a>

        <div class="ms-auto flex items-center gap-2">
            <button class="p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700" @click="dark = !dark"
                aria-label="Toggle theme">🌓</button>

            @auth
                <div class="flex items-center gap-2">
                    <span class="text-sm opacity-70 hidden sm:inline">Hi, {{ auth()->user()->nama }}</span>
                    <!-- logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="text-sm underline">Logout</button>
                    </form>
                </div>
            @endauth
        </div>
    </div>
</header>
