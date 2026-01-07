@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">

    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-title-md2 font-semibold text-gray-800 dark:text-white/90">
            Daftar Invoice
        </h2>

        <a href="{{ route('warehouse.invoices.create') }}"
           class="rounded-lg bg-primary px-4 py-2 text-white hover:bg-primary/90">
            + Buat Invoice
        </a>
    </div>

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="max-w-full overflow-x-auto custom-scrollbar">
            <table class="w-full min-w-[900px]">
                <thead>
                    <tr class="border-b border-gray-100 dark:border-gray-800">
                        <th class="th">No Invoice</th>
                        <th class="th">Tanggal</th>
                        <th class="th">Customer</th>
                        <th class="th">Status</th>
                        <th class="th text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invoices as $invoice)
                    <tr class="border-b border-gray-100 dark:border-gray-800">
                        <td class="td">{{ $invoice->invoice_no }}</td>
                        <td class="td">{{ $invoice->invoice_date }}</td>
                        <td class="td">{{ $invoice->customer_name }}</td>
                        <td class="td">
                            <span class="rounded-full px-3 py-1 text-xs font-medium
                                {{ $invoice->status === 'paid'
                                    ? 'bg-green-100 text-green-700 dark:bg-green-500/10 dark:text-green-400'
                                    : 'bg-red-100 text-red-700 dark:bg-red-500/10 dark:text-red-400' }}">
                                {{ strtoupper($invoice->status) }}
                            </span>
                        </td>
                        <td class="td text-center">
                            <a href="{{ route('warehouse.invoices.show', $invoice) }}"
                               class="text-primary hover:underline">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="td text-center text-gray-500">
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
