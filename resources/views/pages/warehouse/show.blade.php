@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-screen-xl p-4 md:p-6 2xl:p-10">

    <h2 class="mb-6 text-title-md2 font-semibold text-gray-800 dark:text-white/90">
        Detail Barang
    </h2>

    <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>
                <p class="text-theme-xs text-gray-500">SKU</p>
                <p class="font-medium dark:text-white/90">{{ $item->sku }}</p>
            </div>

            <div>
                <p class="text-theme-xs text-gray-500">Nama Barang</p>
                <p class="font-medium dark:text-white/90">
                    {{ optional($item->handoverItem)->item_name }}
                </p>
            </div>

            <div>
                <p class="text-theme-xs text-gray-500">Stok Saat Ini</p>
                <p class="text-lg font-semibold">{{ $item->quantity }}</p>
            </div>

            <div>
                <p class="text-theme-xs text-gray-500">Status</p>
                <span class="inline-flex rounded-full bg-green-50 px-3 py-1 text-sm font-medium text-green-700
                             dark:bg-green-500/15 dark:text-green-500">
                    {{ ucfirst($item->status) }}
                </span>
            </div>

        </div>
    </div>

    <a href="{{ route('pages.warehouse.items.index') }}"
       class="mt-6 inline-block rounded-md border border-gray-300 px-4 py-2 text-sm
              dark:border-gray-700 dark:text-white">
        Kembali
    </a>

</div>
@endsection
