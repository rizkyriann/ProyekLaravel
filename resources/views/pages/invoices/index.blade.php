@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">

    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-title-md2 font-semibold text-gray-800 dark:text-white/90">
            Daftar Invoice
        </h2>

        <a href="{{ route('warehouse.invoices.create') }}">
            <x-ui.button size="md" variant="primary" class="whitespace-nowrap px-3 py-2 text-md">
                Tambah Invoice
            </x-ui.button>
        </a>

    </div>

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="max-w-full overflow-x-auto">
            <table class="w-full min-w-[900px] border-collapse">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-800">
                        <th class="px-5 py-4 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">
                            No Invoice
                        </th>
                        <th class="px-5 py-4 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">
                            Tanggal
                        </th>
                        <th class="px-5 py-4 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">
                            Customer
                        </th>
                        <th class="px-5 py-4 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">
                            Status
                        </th>
                        <th class="px-5 py-4 text-center text-sm font-semibold text-gray-600 dark:text-gray-300">
                            Aksi
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($invoices as $invoice)
                    <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.04]">
                        <td class="px-5 py-4 text-theme-sm text-gray-700 dark:text-gray-300">
                            {{ $invoice->invoice_no }}
                        </td>
                        <td class="px-5 py-4 text-theme-sm text-gray-700 dark:text-gray-300">
                            {{ \Carbon\Carbon::parse($invoice->date)->format('d M Y') }}
                        </td>
                        <td class="px-5 py-4 text-theme-sm text-gray-700 dark:text-gray-300">
                            {{ $invoice->customer }}
                        </td>
                        <td class="px-5 py-4">
                            <span class="inline-flex rounded-full px-3 py-1 text-xs font-medium
                                {{ $invoice->status === 'paid'
                                    ? 'bg-green-100 text-green-700 dark:bg-green-500/10 dark:text-green-400'
                                    : 'bg-red-100 text-red-700 dark:bg-red-500/10 dark:text-red-400' }}">
                                {{ strtoupper($invoice->status) }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-center">
                            <a href="{{ route('warehouse.invoices.show', $invoice->id) }}"
                            class="inline-flex items-center justify-center rounded-md bg-primary px-2 py-1
                                    text-gray-800 hover:bg-primary/90 dark:text-white/90">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                    <path fill-rule="evenodd" d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 0 0-.673-.05A3 3 0 0 0 15 1.5h-1.5a3 3 0 0 0-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6ZM13.5 3A1.5 1.5 0 0 0 12 4.5h4.5A1.5 1.5 0 0 0 15 3h-1.5Z" clip-rule="evenodd" />
                                    <path fill-rule="evenodd" d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V9.375ZM6 12a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V12Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75ZM6 15a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V15Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75ZM6 18a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V18Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5"
                            class="px-5 py-6 text-center text-theme-sm text-gray-500 dark:text-gray-400">
                            Belum ada invoice
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
