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
                    <tr class="border-b border-gray-100 dark:border-gray-800">

                        <th class="px-5 py-3 text-left sm:px-6">
                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                No Handover
                            </p>
                        </th>

                        <th class="px-5 py-3 text-left sm:px-6">
                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                Sumber
                            </p>
                        </th>

                        <th class="px-5 py-3 text-left sm:px-6">
                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                Tanggal
                            </p>
                        </th>

                        <th class="px-5 py-3 text-left sm:px-6">
                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                Jumlah Item
                            </p>
                        </th>

                        <th class="px-5 py-3 text-left sm:px-6">
                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                Status
                            </p>
                        </th>

                        <th class="px-5 py-3 text-center sm:px-6 w-[120px]">
                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                Aksi
                            </p>
                        </th>

                    </tr>
                </thead>

                <tbody>
                    @forelse ($handovers as $handover)
                        <tr class="border-b border-gray-100 dark:border-gray-800">

                            <!-- No Handover -->
                            <td class="px-5 py-4 sm:px-6">
                                <p class="font-medium text-gray-800 text-theme-sm dark:text-white/90">
                                    {{ $handover->handover_no }}
                                </p>
                            </td>

                            <!-- Source -->
                            <td class="px-5 py-4 sm:px-6">
                                <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                                    {{ $handover->source }}
                                </p>
                            </td>

                            <!-- Date -->
                            <td class="px-5 py-4 sm:px-6">
                                <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                                    {{ \Carbon\Carbon::parse($handover->handover_date)->format('d M Y') }}
                                </p>
                            </td>

                            <!-- Total Items -->
                            <td class="px-5 py-4 sm:px-6">
                                <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                                    {{ $handover->handoverItems->count() }} item
                                </p>
                            </td>

                            <!-- Status -->
                            <td class="px-5 py-4 sm:px-6">
                                <span class="inline-flex rounded-full bg-green-50 px-2 py-0.5
                                    text-theme-xs font-medium text-green-700
                                    dark:bg-green-500/15 dark:text-green-500">
                                    {{ ucfirst($handover->status) }}
                                </span>
                            </td>

                            <!-- Action -->
                            <td class="px-5 py-4 sm:px-6">
                                <div class="flex items-center justify-center gap-3">

                                    <!-- Detail -->
                                    <a href="{{ route('warehouse.handovers.show', $handover) }}"
                                       class="inline-flex items-center justify-center rounded-md bg-primary p-2
                                              text-gray-800 hover:bg-primary/90 dark:text-white/90">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none"
                                             viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M15 12H9m12 0A9 9 0 11 3 12a9 9 0 0121 0z" />
                                        </svg>
                                    </a>

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
