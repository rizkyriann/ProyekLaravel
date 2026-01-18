@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">

    {{-- HEADER --}}
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-semibold text-gray-900 dark:text-white">
            Detail Invoice
        </h2>

        <div class="flex gap-2">
            @if ($invoice->status === 'paid')
                <form method="POST" action="{{ route('warehouse.invoices.cancel', $invoice) }}">
                    @csrf
                    @method('PATCH')
                    <button
                        class="inline-flex items-center rounded-lg bg-danger px-4 py-2 text-sm font-medium text-white hover:bg-danger/90">
                        Cancel Invoice
                    </button>
                </form>
            @endif

            @if ($invoice->status === 'draft')
                <form method="POST"
                      action="{{ route('warehouse.invoices.confirm', $invoice) }}"
                      onsubmit="return confirm('Yakin konfirmasi invoice ini?')">
                    @csrf
                    @method('PUT')
                    <button
                        class="inline-flex items-center rounded-lg bg-success px-4 py-2 text-sm font-medium text-white hover:bg-success/90">
                        ✔ Konfirmasi / Paid
                    </button>
                </form>
            @endif
        </div>
    </div>

    {{-- INFO CARD --}}
    <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-3">

        <div class="rounded-xl border border-stroke bg-gray-50 p-4
                    dark:border-strokedark dark:bg-boxdark">
            <p class="text-sm text-gray-600 dark:text-gray-400">Invoice No</p>
            <p class="font-semibold text-gray-900 dark:text-white">
                {{ $invoice->invoice_no }}
            </p>
        </div>

        <div class="rounded-xl border border-stroke bg-gray-50 p-4
                    dark:border-strokedark dark:bg-boxdark">
            <p class="text-sm text-gray-600 dark:text-gray-400">Customer</p>
            <p class="font-semibold text-gray-900 dark:text-white">
                {{ $invoice->customer }}
            </p>
        </div>

        <div class="rounded-xl border border-stroke bg-gray-50 p-4
                    dark:border-strokedark dark:bg-boxdark">
            <p class="text-sm text-gray-600 dark:text-gray-400">Tanggal</p>
            <p class="font-semibold text-gray-900 dark:text-white">
                {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d-m-Y') }}
            </p>
        </div>

    </div>

    {{-- TABLE --}}
    <div class="rounded-xl border border-stroke bg-gray-50 shadow-default
                dark:border-strokedark dark:bg-boxdark">

        <div class="overflow-x-auto">
            <table class="w-full table-auto">

                <thead>
                    <tr class="border-b border-stroke dark:border-strokedark">
                        <th class="px-4 py-3 text-left text-sm font-medium
                                   text-gray-700 dark:text-gray-300">
                            Barang
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-medium
                                   text-gray-700 dark:text-gray-300">
                            Qty
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-medium
                                   text-gray-700 dark:text-gray-300">
                            Harga
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-medium
                                   text-gray-700 dark:text-gray-300">
                            Subtotal
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($invoice->items as $row)
                        <tr class="border-b border-stroke dark:border-strokedark
                                   hover:bg-gray-100 dark:hover:bg-white/5 transition">
                            <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-200">
                                {{ $row->item->name }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-200">
                                {{ $row->quantity }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-200">
                                Rp {{ number_format($row->price, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3 text-sm font-semibold
                                       text-gray-900 dark:text-white">
                                Rp {{ number_format($row->subtotal, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

    </div>

</div>
@endsection
