@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">

    <!-- Page Title -->
    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-title-md2 font-semibold text-gray-800 dark:text-white/90">
            Detail Handover
        </h2>

        <a href="{{ route('warehouse.handovers.index') }}"
           class="inline-flex items-center gap-2 rounded-lg border border-gray-300 px-4 py-2
                  text-sm font-medium text-gray-700 hover:bg-gray-100
                  dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800">
            ← Kembali
        </a>
    </div>

    <!-- Info Cards -->
    <div class="mb-6 grid grid-cols-1 gap-6 md:grid-cols-3">
        <div class="rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.03]">
            <p class="text-sm text-gray-500 dark:text-gray-400">Nomor Handover</p>
            <p class="mt-1 font-semibold text-gray-800 dark:text-gray-100">
                {{ $handover->handover_no }}
            </p>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.03]">
            <p class="text-sm text-gray-500 dark:text-gray-400">Sumber</p>
            <p class="mt-1 font-semibold text-gray-800 dark:text-gray-100">
                {{ $handover->source }}
            </p>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.03]">
            <p class="text-sm text-gray-500 dark:text-gray-400">Tanggal</p>
            <p class="mt-1 font-semibold text-gray-800 dark:text-gray-100">
                {{ \Carbon\Carbon::parse($handover->handover_date)->format('d M Y') }}
            </p>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="max-w-full overflow-x-auto custom-scrollbar">
            <table class="w-full min-w-[900px] border-collapse">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-600 dark:text-gray-300">SKU</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-600 dark:text-gray-300">Nama Barang</th>
                        <th class="px-4 py-3 text-right text-sm font-medium text-gray-600 dark:text-gray-300">Qty</th>
                        <th class="px-4 py-3 text-right text-sm font-medium text-gray-600 dark:text-gray-300">Harga</th>
                        <th class="px-4 py-3 text-right text-sm font-medium text-gray-600 dark:text-gray-300">Subtotal</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @php $grandTotal = 0; @endphp

                    @forelse($handover->handoverItems as $item)
                        @php
                            $subtotal = $item->quantity * $item->price;
                            $grandTotal += $subtotal;
                        @endphp
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 transition">
                            <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-100">{{ $item->sku }}</td>
                            <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-100">{{ $item->item_name }}</td>
                            <td class="px-4 py-3 text-sm text-right font-medium text-gray-800 dark:text-gray-100">{{ $item->quantity }}</td>
                            <td class="px-4 py-3 text-sm text-right text-gray-800 dark:text-gray-100">Rp {{ number_format($item->price) }}</td>
                            <td class="px-4 py-3 text-sm text-right font-semibold text-gray-800 dark:text-gray-100">Rp {{ number_format($subtotal) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-400">
                                Tidak ada item pada handover ini
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Footer Total & Action -->
        <div class="flex flex-col items-end gap-4 border-t border-gray-200 bg-gray-50 px-6 py-4
                    dark:border-gray-800 dark:bg-gray-800/40">

            <div class="text-right">
                <p class="text-sm text-gray-500 dark:text-gray-400">Total Nilai Handover</p>
                <p class="text-lg font-bold text-gray-800 dark:text-gray-100">
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
                        <x-ui.button type="submit" size="sm" class="bg-green-600 hover:bg-green-700">
                            Confirm Handover
                        </x-ui.button>
                    </form>
                @endif

                {{-- Cancel --}}
                @if(in_array($handover->status, ['draft', 'confirmed']))
                    <form action="{{ route('warehouse.handovers.cancel', $handover->id) }}" method="POST" onsubmit="return confirm('Apakah anda yakin ingin membatalkan handover ini?');">
                        @csrf
                        <x-ui.button type="submit" size="sm" class="bg-red-600 hover:bg-red-700">
                            Cancel Handover
                        </x-ui.button>
                    </form>
                @endif
            </div>
</div>
@endsection
