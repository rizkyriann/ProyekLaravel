@extends('layouts.app')

@section('content')
<div class="page-shell">

    {{-- HEADER --}}
    <div class="page-header">
        <div>
            <h2 class="page-title">Detail Invoice</h2>
            <p class="page-subtitle">Ringkasan invoice, status pembayaran, dan item barang keluar.</p>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('warehouse.invoices.index') }}"
               class="table-action">
                Kembali
            </a>

            @if ($invoice->status === 'paid')
                <form method="POST" action="{{ route('warehouse.invoices.cancel', $invoice) }}">
                    @csrf
                    @method('PATCH')
                    <button
                        class="btn-danger">
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
                        class="inline-flex min-h-10 items-center rounded-xl bg-success-500 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-success-600">
                        Konfirmasi / Paid
                    </button>
                </form>
            @endif
        </div>
    </div>

    {{-- INFO CARD --}}
    <div class="grid grid-cols-1 gap-4 md:grid-cols-4">

        <div class="ui-card ui-card-body">
            <p class="text-sm font-semibold text-slate-500">Invoice No</p>
            <p class="mt-1 font-bold text-slate-900">
                {{ $invoice->invoice_no }}
            </p>
        </div>

        <div class="ui-card ui-card-body">
            <p class="text-sm font-semibold text-slate-500">Customer</p>
            <p class="mt-1 font-bold text-slate-900">
                {{ $invoice->customer }}
            </p>
        </div>

        <div class="ui-card ui-card-body">
            <p class="text-sm font-semibold text-slate-500">Tanggal</p>
            <p class="mt-1 font-bold text-slate-900">
                {{ \Carbon\Carbon::parse($invoice->date)->format('d-m-Y') }}
            </p>
        </div>

        <div class="ui-card ui-card-body">
            <p class="text-sm font-semibold text-slate-500">Status</p>
            <p class="mt-2">
                <span class="status-badge status-{{ $invoice->status }}">
                {{ strtoupper($invoice->status) }}
                </span>
            </p>
        </div>

    </div>

    {{-- TABLE --}}
    <div class="table-card">

        <div class="overflow-x-auto">
            <table class="w-full table-auto">

                <thead>
                    <tr>
                        <th>
                            Barang
                        </th>
                        <th>
                            Qty
                        </th>
                        <th>
                            Harga
                        </th>
                        <th>
                            Subtotal
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($invoice->items as $row)
                        <tr>
                            <td class="font-semibold text-slate-900">
                                {{ $row->item->name }}
                            </td>
                            <td>
                                {{ $row->quantity }}
                            </td>
                            <td>
                                Rp {{ number_format($row->price, 0, ',', '.') }}
                            </td>
                            <td class="font-bold text-slate-900">
                                Rp {{ number_format($row->subtotal, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>

                <tfoot>
                    <tr>
                        <td colspan="3" class="text-right text-sm font-semibold text-slate-600">
                            Total
                        </td>
                        <td class="text-sm font-bold text-slate-900">
                            Rp {{ number_format($invoice->total, 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>

            </table>
        </div>

    </div>

</div>
@endsection
