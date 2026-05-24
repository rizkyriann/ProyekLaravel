@extends('layouts.app')

@section('content')
<div class="page-shell">

    <div class="page-header">
        <div>
            <h2 class="page-title">Daftar Invoice</h2>
            <p class="page-subtitle">Buat, konfirmasi, dan pantau transaksi barang keluar.</p>
        </div>

        <a href="{{ route('warehouse.invoices.create') }}">
            <x-ui.button size="md" variant="primary" class="whitespace-nowrap">
                Tambah Invoice
            </x-ui.button>
        </a>

    </div>

    <div class="table-card">
        <div class="table-scroll">
            <table class="min-w-[900px]">
                <thead>
                    <tr>
                        <th>
                            No Invoice
                        </th>
                        <th>
                            Tanggal
                        </th>
                        <th>
                            Customer
                        </th>
                        <th class="text-right">
                            Total
                        </th>
                        <th>
                            Status
                        </th>
                        <th class="text-center">
                            Aksi
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($invoices as $invoice)
                    <tr>
                        <td class="font-bold text-slate-900">
                            {{ $invoice->invoice_no }}
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($invoice->date)->format('d M Y') }}
                        </td>
                        <td>
                            {{ $invoice->customer }}
                        </td>
                        <td class="text-right font-bold text-slate-900">
                            Rp {{ number_format($invoice->total, 0, ',', '.') }}
                        </td>
                        <td>
                            <span class="status-badge status-{{ $invoice->status }}">
                                {{ strtoupper($invoice->status) }}
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('warehouse.invoices.show', $invoice->id) }}"
                            class="table-action-primary">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6"
                            class="py-10 text-center text-sm font-medium text-slate-500">
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
