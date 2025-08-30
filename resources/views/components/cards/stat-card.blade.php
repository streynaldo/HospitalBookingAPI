<div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
    <div
        class="flex items-center justify-center w-10 h-10 mr-4 
            text-orange-500 bg-orange-100 rounded-full 
            dark:text-orange-100 dark:bg-orange-500">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
            <path d="{{ $icon }}" />
        </svg>
    </div>
    <div>
        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
            {{ $label ?? 'Total Users' }}
        </p>
        <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
            {{ $value ?? '0' }}
        </p>
    </div>
</div>
