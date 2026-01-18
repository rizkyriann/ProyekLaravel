@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-screen-xl p-4 md:p-6 2xl:p-10">

    <h2 class="mb-6 text-title-md2 font-semibold text-gray-800 dark:text-white/90">
        Detail Barang
    </h2>

    <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-gray-900">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>
                <p class="text-sm text-gray-500">Nama Barang</p>
                <p class="font-semibold dark:text-gray-400"> {{ $item->name }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">SKU</p>
                <p class="font-semibold dark:text-gray-400">{{ $item->sku }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Stok Saat Ini</p>
                <p class="font-semibold text-lg dark:text-gray-400">{{ $item->quantity }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Harga Beli</p>
                <p class="font-semibold dark:text-gray-400">
                    Rp {{ number_format($item->price, 0, ',', '.') }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Tanggal Masuk</p>
                <p class="font-semibold dark:text-gray-400">{{ $item->handover->handover_date }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Nama Supplier</p>
                <p class="font-semibold dark:text-gray-400">{{ $item->handover->source }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Nomor Handover</p>
                <p class="font-semibold dark:text-gray-400">{{ $item->handover->handover_no }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Status</p>
                <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-md font-medium text-green-700">
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
