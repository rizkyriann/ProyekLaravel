@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">

    {{-- Title --}}
    <h2 class="mb-6 text-title-md2 font-semibold text-gray-800 dark:text-white/90">
        Kartu Stok
    </h2>

    {{-- Item Info --}}
    <div class="mb-4 rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.03]">
        <p class="font-medium dark:text-white/90">
            {{ $item->name }}
        </p>
        <p class="text-theme-xs text-gray-500">
            SKU: {{ $item->sku }} |
            Stok Saat Ini:
            <span class="font-semibold">{{ $item->quantity }}</span>
        </p>
    </div>

    {{-- Table --}}
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

                    {{-- ================= BARANG MASUK ================= --}}
                    @forelse ($item->handoverItems as $handoverItem)
                    <tr class="border-b border-gray-100 dark:border-gray-800">
                        <td class="px-5 py-4 text-sm text-gray-700 dark:text-gray-300">
                            {{ $handoverItem->handover->handover_date }}
                        </td>

                        <td class="px-5 py-4 text-sm text-gray-700 dark:text-gray-300">
                            HO-{{ $handoverItem->handover->handover_no }}
                        </td>

                        <td class="px-5 py-4 text-center font-semibold text-green-600">
                            {{ $handoverItem->quantity }}
                        </td>

                        <td class="px-5 py-4 text-center">
                            -
                        </td>

                        <td class="px-5 py-4">
                            Barang Masuk Gudang
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-4 text-center text-gray-500">
                            Belum ada transaksi barang masuk
                        </td>
                    </tr>
                    @endforelse

                    {{-- ================= BARANG KELUAR ================= --}}
                    @forelse ($item->invoiceItems as $invoiceItem)
                    <tr class="border-b border-gray-100 dark:border-gray-800">
                        <td class="px-5 py-4 text-sm text-gray-700 dark:text-gray-300">
                            {{ $invoiceItem->invoice->date }}
                        </td>

                        <td class="px-5 py-4 text-sm text-gray-700 dark:text-gray-300">
                            INV-{{ $invoiceItem->invoice->invoice_number }}
                        </td>

                        <td class="px-5 py-4 text-center">
                            -
                        </td>

                        <td class="px-5 py-4 text-center font-semibold text-red-600">
                            {{ $invoiceItem->quantity }}
                        </td>

                        <td class="px-5 py-4">
                            Barang Keluar (Invoice)
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-4 text-center text-gray-500">
                            Belum ada transaksi barang keluar
                        </td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>

    {{-- Back Button --}}
    <a href="{{ route('warehouse.items.index') }}"
       class="mt-6 inline-flex items-center rounded-md border border-gray-300 px-4 py-2 text-sm
              transition hover:bg-gray-100 dark:border-gray-700 dark:text-white dark:hover:bg-white/10">
        ← Kembali
    </a>

</div>
@endsection
