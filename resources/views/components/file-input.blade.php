<div x-data="{ fileName: '' }">
    <label class="mb-2 block text-sm font-medium text-black dark:text-white">
        {{ $label }}
    </label>

    <label
        class="flex cursor-pointer items-center gap-3 rounded border border-stroke
               bg-transparent px-4 py-3 text-sm
               text-gray-500 hover:border-primary
               dark:border-strokedark dark:text-gray-400">

        <!-- SVG ICON -->
        <svg class="h-5 w-5 fill-current text-primary" viewBox="0 0 24 24">
            <path d="M12 16a1 1 0 0 1-1-1V7.414L8.707 9.707a1
                     1 0 0 1-1.414-1.414l4-4a1
                     1 0 0 1 1.414 0l4 4a1
                     1 0 1 1-1.414 1.414L13
                     7.414V15a1 1 0 0 1-1 1z"/>
            <path d="M5 18a1 1 0 0 1-1-1v-2a1
                     1 0 1 1 2 0v1h12v-1a1
                     1 0 1 1 2 0v2a1 1
                     0 0 1-1 1H5z"/>
        </svg>

        <!-- TEXT -->
        <span x-text="fileName || 'Pilih file'"></span>

        <!-- REAL INPUT -->
        <input
            type="file"
            name="{{ $name }}"
            class="hidden"
            @change="fileName = $event.target.files[0]?.name"
            {{ $attributes }}
        >
    </label>
</div>
