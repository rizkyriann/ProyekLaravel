@extends('layouts.app')

@section('content')
<div class="page-shell">

    <!-- Page Title -->
    <div class="page-header">
        <div>
            <h2 class="page-title">Detail Handover</h2>
            <p class="page-subtitle">Cek detail barang masuk sebelum confirm atau cancel dokumen.</p>
        </div>

        <a href="{{ route('warehouse.handovers.index') }}"
           class="table-action">
            Kembali
        </a>
    </div>

    <!-- Info Cards -->
    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
        <div class="ui-card ui-card-body">
            <p class="text-sm font-semibold text-slate-500">Nomor Handover</p>
            <p class="mt-1 font-bold text-slate-900">
                {{ $handover->handover_no }}
            </p>
        </div>

        <div class="ui-card ui-card-body">
            <p class="text-sm font-semibold text-slate-500">Sumber</p>
            <p class="mt-1 font-bold text-slate-900">
                {{ $handover->source }}
            </p>
        </div>

        <div class="ui-card ui-card-body">
            <p class="text-sm font-semibold text-slate-500">Tanggal</p>
            <p class="mt-1 font-bold text-slate-900">
                {{ \Carbon\Carbon::parse($handover->handover_date)->format('d M Y') }}
            </p>
        </div>
    </div>

    <!-- Table -->
    <div class="table-card">
        <div class="max-w-full overflow-x-auto custom-scrollbar">
            <table class="w-full min-w-[900px] border-collapse">
                <thead>
                    <tr>
                        <th>SKU</th>
                        <th>Nama Barang</th>
                        <th class="text-right">Qty</th>
                        <th class="text-right">Harga</th>
                        <th class="text-right">Subtotal</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @php $grandTotal = 0; @endphp

                    @forelse($handover->handoverItems as $item)
                        @php
                            $subtotal = $item->quantity * $item->price;
                            $grandTotal += $subtotal;
                        @endphp
                        <tr>
                            <td class="font-bold text-slate-900">{{ $item->sku }}</td>
                            <td>{{ $item->item_name }}</td>
                            <td class="text-right font-semibold">{{ $item->quantity }}</td>
                            <td class="text-right">Rp {{ number_format($item->price) }}</td>
                            <td class="text-right font-bold text-slate-900">Rp {{ number_format($subtotal) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-10 text-center text-sm font-medium text-slate-500">
                                Tidak ada item pada handover ini
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Footer Total & Action -->
        <div class="flex flex-col items-end gap-4 border-t border-slate-200 bg-slate-50 px-6 py-4">

            <div class="text-right">
                <p class="text-sm font-semibold text-slate-500">Total Nilai Handover</p>
                <p class="text-xl font-bold text-slate-900">
                    Rp {{ number_format($grandTotal) }}
                </p>
            </div>
        </div>
    </div>
         {{-- Action Buttons --}}
            <div class="flex justify-end items-center gap-3 mt-4">
                {{-- Confirm --}}
                @if($handover->status === 'draft')
                    <form action="{{ route('warehouse.handovers.confirm', $handover->id) }}" method="POST">
                        @csrf
                        <x-ui.button type="submit" size="sm" class="bg-success-500 hover:bg-success-600 focus:ring-success-500/20">
                            Confirm Handover
                        </x-ui.button>
                    </form>
                @endif

                {{-- Cancel --}}
                @if(in_array($handover->status, ['draft', 'confirmed']))
                    <form action="{{ route('warehouse.handovers.cancel', $handover->id) }}" method="POST" onsubmit="return confirm('Apakah anda yakin ingin membatalkan handover ini?');">
                        @csrf
                        <button type="submit" class="btn-danger">
                            Cancel Handover
                        </button>
                    </form>
                @endif
            </div>
</div>
@endsection
