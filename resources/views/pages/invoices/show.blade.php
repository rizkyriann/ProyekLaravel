@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">

    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-title-md2 font-semibold text-gray-800 dark:text-white/90">
            Detail Invoice
        </h2>

        @if($invoice->status === 'paid')
        <form method="POST" action="{{ route('warehouse.invoices.cancel', $invoice) }}">
            @csrf
            @method('PUT')
            <button class="rounded-lg bg-red-500 px-4 py-2 text-white">
                Cancel Invoice
            </button>
        </form>
        @endif
    </div>

    <!-- Header -->
    <div class="mb-6 grid grid-cols-1 gap-6 md:grid-cols-3">
        <div class="card">No: {{ $invoice->invoice_no }}</div>
        <div class="card">Customer: {{ $invoice->customer_name }}</div>
        <div class="card">Tanggal: {{ $invoice->invoice_date }}</div>
    </div>

    <!-- Items -->
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-100 dark:border-gray-800">
                    <th class="th">Barang</th>
                    <th class="th">Qty</th>
                    <th class="th">Harga</th>
                    <th class="th">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->items as $row)
                <tr class="border-b border-gray-100 dark:border-gray-800">
                    <td class="td">{{ $row->item->name }}</td>
                    <td class="td">{{ $row->quantity }}</td>
                    <td class="td">Rp {{ number_format($row->price) }}</td>
                    <td class="td">Rp {{ number_format($row->subtotal) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection
