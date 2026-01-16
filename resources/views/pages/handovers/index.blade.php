@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">

    <!-- Header -->
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-title-md2 font-semibold text-gray-800 dark:text-white/90">
            Data Handover (Barang Masuk)
        </h2>

        <a href="{{ route('warehouse.handovers.create') }}">
            <x-ui.button size="md" variant="primary">
                Tambah Handover
            </x-ui.button>
        </a>
    </div>

    <!-- Table Wrapper -->
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="max-w-full overflow-x-auto custom-scrollbar">
            <table class="w-full min-w-[1100px]">
                <thead>
                    <tr class="border bg-gray-100 dark:bg-gray-800 border-gray-200 dark:border-gray-800">
                        <th class="px-5 py-3 text-left sm:px-6">
                            <p class="font-medium text-gray-500 dark:text-gray-400">
                                No Handover
                            </p>
                        </th>

                        <th class="px-5 py-2 text-left sm:px-6">
                            <p class="font-medium text-gray-500 dark:text-gray-400">
                                Sumber
                            </p>
                        </th>

                        <th class="px-5 py-2 text-left sm:px-6">
                            <p class="font-medium text-gray-500 dark:text-gray-400">
                                Tanggal
                            </p>
                        </th>

                        <th class="px-5 py-2 text-left sm:px-6">
                            <p class="font-medium text-gray-500 dark:text-gray-400">
                                Jumlah Item
                            </p>
                        </th>

                        <th class="px-5 py-2 text-left sm:px-6">
                            <p class="font-medium text-gray-500 dark:text-gray-400">
                                Status
                            </p>
                        </th>

                        <th class="px-5 py-2 text-center sm:px-6 w-[120px]">
                            <p class="font-medium text-gray-500 dark:text-gray-400">
                                Aksi
                            </p>
                        </th>

                    </tr>
                </thead>

                <tbody>
                    @forelse ($handovers as $handover)
                        <tr class="border-b border-gray-200 dark:border-gray-800">

                            <!-- No Handover -->
                            <td class="px-5 py-2 sm:px-6">
                                <p class="font-medium text-gray-800 text-theme-sm dark:text-white/90">
                                    {{ $handover->handover_no }}
                                </p>
                            </td>

                            <!-- Source -->
                            <td class="px-5 py-2 sm:px-6">
                                <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                                    {{ $handover->source }}
                                </p>
                            </td>

                            <!-- Date -->
                            <td class="px-5 py-2 sm:px-6">
                                <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                                    {{ \Carbon\Carbon::parse($handover->handover_date)->format('d M Y') }}
                                </p>
                            </td>

                            <!-- Total Items -->
                            <td class="px-5 py-2 sm:px-6">
                                <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                                    {{ $handover->handoverItems->count() }} item
                                </p>
                            </td>

                            <!-- Status -->
                            <td class="px-5 py-2 sm:px-6">
                                <span class="inline-flex rounded-full px-2 py-0.5 text-theme-xs font-medium {{ $handover->status_badge_class }}">
                                    {{ ucfirst($handover->status) }}
                                </span>
                            </td>

                            <!-- Action -->
                            <td class="px-1 py-1 sm:px-6">
                                <div class="flex items-center justify-center gap-3">
                                    <!-- Detail -->
                                    <a href="{{ route('warehouse.handovers.show', $handover) }}"
                                       class="inline-flex items-center justify-center rounded-md bg-primary px-2 py-1
                                              text-gray-800 hover:bg-primary/90 dark:text-white/90">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-7 mt-5">
                                            <path d="M11.625 16.5a1.875 1.875 0 1 0 0-3.75 1.875 1.875 0 0 0 0 3.75Z" />
                                            <path fill-rule="evenodd" d="M5.625 1.5H9a3.75 3.75 0 0 1 3.75 3.75v1.875c0 1.036.84 1.875 1.875 1.875H16.5a3.75 3.75 0 0 1 3.75 3.75v7.875c0 1.035-.84 1.875-1.875 1.875H5.625a1.875 1.875 0 0 1-1.875-1.875V3.375c0-1.036.84-1.875 1.875-1.875Zm6 16.5c.66 0 1.277-.19 1.797-.518l1.048 1.048a.75.75 0 0 0 1.06-1.06l-1.047-1.048A3.375 3.375 0 1 0 11.625 18Z" clip-rule="evenodd" />
                                            <path d="M14.25 5.25a5.23 5.23 0 0 0-1.279-3.434 9.768 9.768 0 0 1 6.963 6.963A5.23 5.23 0 0 0 16.5 7.5h-1.875a.375.375 0 0 1-.375-.375V5.25Z" />
                                        </svg>
                                    </a>

                                    <!--Edit-->
                                    <a href="{{ route('warehouse.handovers.edit', $handover) }}"
                                       class="inline-flex items-center justify-center rounded-md bg-primary px-2 py-1
                                              text-gray-800 hover:bg-primary/90 dark:text-white/90">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-7 mt-5">
                                            <path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625ZM7.5 15a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 7.5 15Zm.75 2.25a.75.75 0 0 0 0 1.5H12a.75.75 0 0 0 0-1.5H8.25Z" clip-rule="evenodd" />
                                            <path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z" />
                                        </svg>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-8 text-center text-gray-500 dark:text-gray-400">
                                Data handover belum tersedia
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>

</div>
@endsection
