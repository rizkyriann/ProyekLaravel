@extends('layouts.app')

@section('content')
<div class="page-shell">

    <div class="page-header">
        <div>
            <h2 class="page-title">Kartu Stok</h2>
            <p class="page-subtitle">Riwayat barang masuk dari handover dan barang keluar dari invoice paid.</p>
        </div>
        <a href="{{ route('warehouse.items.index') }}" class="table-action">Kembali</a>
    </div>

    <!-- Item Info -->
    <div class="ui-card ui-card-body">
        <p class="font-bold text-slate-900">
            {{ optional($item->handoverItem)->item_name ?? '-' }}
        </p>
        <p class="mt-1 text-sm font-medium text-slate-500">
            SKU: {{ $item->sku }} | Stok Saat Ini: {{ $item->quantity }}
        </p>
    </div>

    <!-- Table -->
    <div class="table-card">
        <div class="table-scroll">
        <table class="min-w-[760px]">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                    <th class="text-right">Masuk</th>
                    <th class="text-right">Keluar</th>
                </tr>
            </thead>
            <tbody>

                {{-- Barang Masuk (Handover) --}}
                @if ($item->handoverItem)
                    <tr>
                        <td>
                            {{ optional($item->handoverItem->handover)->handover_date }}
                        </td>
                        <td class="font-semibold text-slate-900">
                            Barang Masuk (Handover)
                        </td>
                        <td class="text-right text-sm font-bold text-success-700">
                            {{ $item->handoverItem->quantity }}
                        </td>
                        <td class="text-right">-</td>
                    </tr>
                @endif

                {{-- Barang Keluar (Invoice) --}}
                @foreach ($item->invoiceItems as $row)
                    <tr>
                        <td>
                            {{ optional($row->invoice)->date }}
                        </td>
                        <td class="font-semibold text-slate-900">
                            Barang Keluar (Invoice)
                        </td>
                        <td class="text-right">-</td>
                        <td class="text-right text-sm font-bold text-error-700">
                            {{ $row->quantity }}
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
        </div>
    </div>

</div>
@endsection
