@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">

    <h2 class="mb-4 text-title-md2 font-semibold text-gray-800 dark:text-white/90">
        Kartu Stok
    </h2>

    <!-- Item Info -->
    <div class="mb-6 rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900">
        <p class="font-medium">
            {{ optional($item->handoverItem)->item_name ?? '-' }}
        </p>
        <p class="text-sm text-gray-500">
            SKU: {{ $item->sku }} | Stok Saat Ini: {{ $item->quantity }}
        </p>
    </div>

    <!-- Table -->
    <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-gray-800">
        <table class="w-full bg-white dark:bg-gray-900">
            <thead>
                <tr class="bg-gray-100 dark:bg-gray-800">
                    <th class="px-5 py-3 text-left text-sm">Tanggal</th>
                    <th class="px-5 py-3 text-left text-sm">Keterangan</th>
                    <th class="px-5 py-3 text-right text-sm">Masuk</th>
                    <th class="px-5 py-3 text-right text-sm">Keluar</th>
                </tr>
            </thead>
            <tbody>

                {{-- Barang Masuk (Handover) --}}
                @foreach ($item->handoverItems as $row)
                    <tr class="border-t dark:border-gray-800">
                        <td class="px-5 py-4 text-sm">
                            {{ optional($row->handover)->handover_date }}
                        </td>
                        <td class="px-5 py-4 text-sm">
                            Barang Masuk (Handover)
                        </td>
                        <td class="px-5 py-4 text-right text-sm font-semibold text-green-600">
                            {{ $row->quantity }}
                        </td>
                        <td class="px-5 py-4 text-right text-sm">-</td>
                    </tr>
                @endforeach

                {{-- Barang Keluar (Invoice) --}}
                @foreach ($item->invoiceItems as $row)
                    <tr class="border-t dark:border-gray-800">
                        <td class="px-5 py-4 text-sm">
                            {{ optional($row->invoice)->invoice_date }}
                        </td>
                        <td class="px-5 py-4 text-sm">
                            Barang Keluar (Invoice)
                        </td>
                        <td class="px-5 py-4 text-right text-sm">-</td>
                        <td class="px-5 py-4 text-right text-sm font-semibold text-red-600">
                            {{ $row->quantity }}
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>

</div>
@endsection
