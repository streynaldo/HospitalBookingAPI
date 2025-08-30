<x-admin.layout title="Edit Janji Temu">
    <div class="mb-4">
        <h1 class="text-2xl md:text-4xl font-semibold text-gray-900 dark:text-gray-100">Edit Janji Temu</h1>
    </div>

    {{-- Warning Messages --}}
    <div id="slot-warning" class="mb-4 p-4 bg-red-100 text-red-700 rounded hidden">
        Slot ini sudah penuh (4 orang). Silakan pilih slot lain.
    </div>
    <div id="day-warning" class="mb-4 p-4 bg-red-100 text-red-700 rounded hidden">
        Tanggal yang dipilih tidak sesuai dengan hari yang tersedia untuk dokter ini. Silakan pilih tanggal lain.
    </div>

    <form action="{{ route('admin.janjitemu.update', $janjitemu->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="pasien_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Pasien</label>
            <select name="pasien_id" id="pasien_id" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:ring-blue-500 focus:border-blue-500" disabled>
                <option value="{{ $janjitemu->pasien_id }}">{{ $janjitemu->pasien->nama }}</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="dokter_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Dokter</label>
            <select name="dokter_id" id="dokter_id" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:ring-blue-500 focus:border-blue-500" disabled>
                <option value="{{ $janjitemu->dokter_id }}">{{ $janjitemu->dokter->nama }}</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="hari_tersedia" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Hari Tersedia</label>
            <ul id="available-days" class="list-disc pl-5 text-gray-700 dark:text-gray-300">
                @foreach ($dokterHariTersedia as $hari)
                <li>{{ $hari }}</li>
                @endforeach
            </ul>
        </div>

        <div class="mb-4">
            <label for="tanggal" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Kedatangan</label>
            <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', $janjitemu->tanggal) }}" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:ring-blue-500 focus:border-blue-500">
            @error('tanggal')
            <span class="text-sm text-red-600">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="slot_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Slot Waktu</label>
            <select name="slot_id" id="slot_id" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:ring-blue-500 focus:border-blue-500">
                @if ($slots->isNotEmpty())
                    @foreach ($slots as $slot)
                        <option value="{{ $slot->id }}" {{ old('slot_id', $janjitemu->slot_id) == $slot->id ? 'selected' : '' }}>
                            {{ $slot->slot_mulai }} - {{ $slot->slot_selesai }}
                        </option>
                    @endforeach
                @else
                    <option value="" disabled>Tidak ada slot tersedia</option>
                @endif
            </select>
            @error('slot_id')
            <span class="text-sm text-red-600">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex justify-end">
            <a href="{{ route('admin.janjitemu.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 mr-2">Batal</a>
            <button id="submit-button" type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
        </div>
    </form>

    <script>
        const tanggalInput = document.getElementById('tanggal');
        const slotSelect = document.getElementById('slot_id');
        const slotWarning = document.getElementById('slot-warning');
        const dayWarning = document.getElementById('day-warning');
        const submitButton = document.getElementById('submit-button');
        const availableDays = Array.from(document.getElementById('available-days').children).map(li => li.textContent);

        function validateForm() {
            const isDayValid = dayWarning.classList.contains('hidden');
            const isSlotValid = slotWarning.classList.contains('hidden');
            submitButton.disabled = !(isDayValid && isSlotValid);
        }

        tanggalInput.addEventListener('change', function () {
            const dokterId = document.getElementById('dokter_id').value;
            const tanggal = this.value;

            // Check if the selected date matches the available days
            const selectedDay = new Date(tanggal).toLocaleDateString('id-ID', { weekday: 'long' });
            if (!availableDays.includes(selectedDay)) {
                dayWarning.classList.remove('hidden');
                validateForm();
                return;
            } else {
                dayWarning.classList.add('hidden');
            }

            // Fetch available slots for the selected date
            fetch(`/admin/${dokterId}/jadwal/${tanggal}/slot`)
                .then(response => response.json())
                .then(data => {
                    slotSelect.innerHTML = '';
                    if (data.data.length > 0) {
                        data.data.forEach(slot => {
                            const option = document.createElement('option');
                            option.value = slot.id;
                            option.textContent = `${slot.slot_mulai} - ${slot.slot_selesai}`;
                            slotSelect.appendChild(option);
                        });
                    } else {
                        const option = document.createElement('option');
                        option.value = '';
                        option.textContent = 'Tidak ada slot tersedia';
                        option.disabled = true;
                        slotSelect.appendChild(option);
                    }
                    validateForm();
                });
        });

        slotSelect.addEventListener('change', function () {
            const slotId = this.value;

            fetch(`/check-slot/${slotId}/${tanggalInput.value}`)
                .then(response => response.json())
                .then(data => {
                    if (data.total_pasien >= 4) {
                        slotWarning.classList.remove('hidden');
                    } else {
                        slotWarning.classList.add('hidden');
                    }
                    validateForm();
                });
        });
    </script>
</x-admin.layout>
