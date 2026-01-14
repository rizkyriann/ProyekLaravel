@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">

    <h2 class="mb-6 text-title-md2 font-semibold text-gray-800 dark:text-white/90">
        Kartu Stok
    </h2>

    <!-- Item Info -->
    <div class="mb-4 rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.03]">
        <p class="font-medium dark:text-white/90">
            {{ optional($item->handoverItem)->item_name }}
        </p>
        <p class="text-theme-xs text-gray-500">
            SKU: {{ $item->sku }} | Stok: {{ $item->quantity }}
        </p>
    </div>

    <!-- Table -->
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="max-w-full overflow-x-auto custom-scrollbar">
            <table class="w-full min-w-[1100px]">
                <thead>
                    <tr class="border-b border-gray-100 dark:border-gray-800">
                        <th class="px-5 py-3 text-left text-theme-xs text-gray-500">Tanggal</th>
                        <th class="px-5 py-3 text-left text-theme-xs text-gray-500">Referensi</th>
                        <th class="px-5 py-3 text-center text-theme-xs text-gray-500">Masuk</th>
                        <th class="px-5 py-3 text-center text-theme-xs text-gray-500">Keluar</th>
                        <th class="px-5 py-3 text-left text-theme-xs text-gray-500">Keterangan</th>
                    </tr>
                </thead>
                <tbody>

                    {{-- Barang Masuk --}}
                    @foreach ($item->handover as $handover)
                    <tr class="border-b border-gray-100 dark:border-gray-800">
                        <td class="px-5 py-4 text-sm text-gray-700 dark:text-gray-300">
                             {{ $item->handoverItems->last()?->handover?->handover_date ?? '-' }}
                        </td>
                        <td class="px-5 py-4 text-sm text-gray-700 dark:text-gray-300">
                             {{ $item->handoverItems->last()?->handover?->id ?? '-' }}
                        </td>
                        <td class="px-5 py-4 text-sm text-gray-700 dark:text-gray-300">
                             {{ $item->handoverItems->last()?->handover?->quantity ?? '-' }}
                        </td>
                        <td class="px-5 py-4 text-center">-</td>
                        <td class="px-5 py-4">Barang Masuk Gudang</td>
                    </tr>
                    @endforeach

                    {{-- Barang Keluar --}}
                    @foreach ($item->invoiceItems as $invoiceItem)
                    <tr class="border-b border-gray-100 dark:border-gray-800">
                        <td class="px-5 py-4">{{ $invoiceItem->invoice->date }}</td>
                        <td class="px-5 py-4">
                            Invoice #{{ $invoiceItem->invoice->invoice_number }}
                        </td>
                        <td class="px-5 py-4 text-center">-</td>
                        <td class="px-5 py-4 text-center text-red-600 font-semibold">
                            {{ $invoiceItem->quantity }}
                        </td>
                        <td class="px-5 py-4">Barang Keluar (Invoice)</td>
                    </tr>
                    @endforeach

                    @if ($item->handoverItems->isEmpty() && $item->invoiceItems->isEmpty())
                    <tr>
                        <td colspan="5" class="px-5 py-6 text-center text-gray-500">
                            Belum ada transaksi
                        </td>
                    </tr>
                    @endif

                </tbody>
            </table>
        </div>
    </div>

    <a href="{{ route('warehouse.items.index') }}"
       class="mt-6 inline-block rounded-md border border-gray-300 px-4 py-2 text-sm
              dark:border-gray-700 dark:text-white">
        Kembali
    </a>

</div>
@endsection
