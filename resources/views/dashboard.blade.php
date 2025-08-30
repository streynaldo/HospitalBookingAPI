<x-admin.layout title="Dashboard">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

        <x-cards.stat-card>
            <x-slot:label>Total Pasien</x-slot:label>
            <x-slot:value>{{ $pasien }}</x-slot:value>
            <x-slot:icon>
                M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 6.015 4.015 4 6.5 4c1.74 0 3.41.81 4.5 2.09C12.09 4.81
                13.76 4 15.5 4 17.985 4 20 6.015 20 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z
            </x-slot:icon>
            <x-slot:color>emerald</x-slot:color>
        </x-cards.stat-card>

        <x-cards.stat-card>
            <x-slot:label>Total Dokter</x-slot:label>
            <x-slot:value>{{ $dokter }}</x-slot:value>
            <x-slot:icon>M20 7h-3V6a3 3 0 00-3-3h-4a3 3 0 00-3 3v1H4a2 2 0 00-2 2v9a2 2 0 002 2h16a2 2 0
                002-2V9a2 2 0 00-2-2zm-11-1a1 1 0 011-1h4a1 1 0 011 1v1H9V6zm5 7h-2v2h-2v-2H8v-2h2v-2h2v2h2v2z
            </x-slot:icon>
            <x-slot:color>blue</x-slot:color>
        </x-cards.stat-card>

        <x-cards.stat-card>
            <x-slot:label>Total User</x-slot:label>
            <x-slot:value>{{ $user }}</x-slot:value>
            <x-slot:icon>M12 14c-4.418 0-8 2.686-8 6v2h16v-2c0-3.314-3.582-6-8-6zm0-2a5 5 0 100-10 5 5 0 000 10z
            </x-slot:icon>
            <x-slot:color>indigo</x-slot:color>
        </x-cards.stat-card>

        <x-cards.stat-card>
            <x-slot:label>Total Klinik</x-slot:label>
            <x-slot:value>{{ $klinik }}</x-slot:value>
            <x-slot:icon>M3 21V9l9-6 9 6v12H3zm7-8V9h4v4h4v4h-4v4h-4v-4H6v-4h4z
            </x-slot:icon>
            <x-slot:color>rose</x-slot:color>
        </x-cards.stat-card>
    </div>
</x-admin.layout>
