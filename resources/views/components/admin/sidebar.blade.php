@php
    $active = fn($pat) => request()->routeIs($pat) ? 'bg-gray-100 dark:bg-gray-700 font-medium' : '';
@endphp

<nav class="space-y-1">
    <a href="{{ route('admin.dashboard') }}"
        class="flex items-center gap-3 px-3 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 {{ $active('admin.dashboard') }}">📊
        <span>Dashboard</span></a>
    <a href="{{ route('admin.klinik.index') }}"
        class="flex items-center gap-3 px-3 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 {{ $active('admin.klinik.*') }}">🏥
        <span>Klinik</span></a>
    <a href="{{ route('admin.user.index') }}"
        class="flex items-center gap-3 px-3 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 {{ $active('admin.user.*') }}">👤
        <span>User</span></a>
    <a href="{{ route('admin.admin.index') }}"
        class="flex items-center gap-3 px-3 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 {{ $active('admin.admin.*') }}">🛡️
        <span>Admin</span></a>
    <a href="{{ route('admin.banner.index') }}"
        class="flex items-center gap-3 px-3 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 {{ $active('admin.promo.*') }}">🏷️
        <span>Banner</span></a>
    <a href="{{ route('admin.dokter.index') }}"
        class="flex items-center gap-3 px-3 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 {{ $active('admin.dokter.*') }}">🧑‍⚕️
        <span>Dokter</span></a>
    <a href="{{ route('admin.janjitemu.index') }}"
        class="flex items-center gap-3 px-3 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 {{ $active('admin.janjitemu.*') }}">📅
        <span>Janji Temu</span></a>
    <a href="{{ route('admin.pasien.index') }}"
        class="flex items-center gap-3 px-3 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 {{ $active('admin.pasien.*') }}">🧑‍💼
        <span>Pasien</span></a>
</nav>
