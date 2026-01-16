@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">

    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-title-md2 font-semibold text-gray-800 dark:text-white/90">
            Daftar Invoice
        </h2>

        <a href="{{ route('warehouse.invoices.create') }}">
            <x-ui.button size="md" variant="primary" class="whitespace-nowrap h-7">
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
                            <a href="{{ route('warehouse.invoices.show', $invoice) }}"
                               class="text-sm font-medium text-primary hover:underline">
                                Detail
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
