@extends('layouts.app')

@section('content')
<div class="page-shell max-w-5xl">

    <div class="page-header">
        <div>
            <h2 class="page-title">Detail Barang</h2>
            <p class="page-subtitle">Informasi stok, harga, dan sumber barang.</p>
        </div>
    </div>

    <div class="ui-card ui-card-body">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>
                <p class="text-sm font-semibold text-slate-500">Nama Barang</p>
                <p class="mt-1 font-bold text-slate-900"> {{ $item->name }}
                </p>
            </div>

            <div>
                <p class="text-sm font-semibold text-slate-500">SKU</p>
                <p class="mt-1 font-bold text-slate-900">{{ $item->sku }}</p>
            </div>

            <div>
                <p class="text-sm font-semibold text-slate-500">Stok Saat Ini</p>
                <p class="mt-1 text-2xl font-bold text-brand-700">{{ $item->quantity }}</p>
            </div>

            <div>
                <p class="text-sm font-semibold text-slate-500">Harga Beli</p>
                <p class="mt-1 font-bold text-slate-900">
                    Rp {{ number_format($item->price, 0, ',', '.') }}
                </p>
            </div>

            <div>
                <p class="text-sm font-semibold text-slate-500">Tanggal Masuk</p>
                <p class="mt-1 font-bold text-slate-900">{{ optional($item->handover)->handover_date ?? '-' }}</p>
            </div>

            <div>
                <p class="text-sm font-semibold text-slate-500">Nama Supplier</p>
                <p class="mt-1 font-bold text-slate-900">{{ optional($item->handover)->source ?? '-' }}</p>
            </div>

            <div>
                <p class="text-sm font-semibold text-slate-500">Nomor Handover</p>
                <p class="mt-1 font-bold text-slate-900">{{ optional($item->handover)->handover_no ?? '-' }}</p>
            </div>

            <div>
                <p class="text-sm font-semibold text-slate-500">Status</p>
                <span class="status-badge status-{{ $item->status }} mt-2">
                    {{ ucfirst($item->status) }}
                </span>
            </div>

        </div>

        <div class="mt-6 flex gap-3">
            <a href="{{ route('warehouse.items.index') }}">
                <x-ui.button variant="outline" size="sm">
                    Kembali
                </x-ui.button>
            </a>
        </div>

    </div>

</div>
@endsection
