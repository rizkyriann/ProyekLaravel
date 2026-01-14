@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">

    <!-- Header -->
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-title-md2 font-semibold text-gray-800 dark:text-white/90">
            Stok Gudang
        </h2>
    </div>

    <!-- Search -->
    <form method="GET" class="mb-4 max-w-md">
        <input
            type="text"
            name="q"
            value="{{ request('q') }}"
            placeholder="Cari SKU / Nama Barang"
            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm
                   focus:border-primary focus:ring-primary
                   dark:border-gray-700 dark:bg-gray-900 dark:text-white"
        />
    </form>

    <!-- Table -->
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="max-w-full overflow-x-auto custom-scrollbar">
            <table class="w-full min-w-[1000px]">
                <thead>
                    <tr class="border-b border-gray-100 dark:border-gray-800">
                        <th class="px-5 py-3 text-left text-theme-xs text-gray-500">SKU</th>
                        <th class="px-5 py-3 text-left text-theme-xs text-gray-500">Nama Barang</th>
                        <th class="px-5 py-3 text-left text-theme-xs text-gray-500">Stok</th>
                        <th class="px-5 py-3 text-center text-theme-xs text-gray-500 w-[160px]">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $item)
                    <tr class="border-b border-gray-100 dark:border-gray-800">
                        <td class="px-5 py-4 text-theme-sm dark:text-white/90">
                            {{ $item->sku }}
                        </td>

                        <td class="px-5 py-4 text-theme-sm text-gray-500 dark:text-gray-400">
                            {{ optional($item->handoverItem)->item_name }}
                        </td>

                        <td class="px-5 py-4 text-theme-sm font-semibold">
                            <span class="{{ $item->quantity > 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $item->quantity }}
                            </span>
                        </td>

                        <td class="px-5 py-4">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('warehouse.items.stock-card', $item->id) }}"
                                   <x-ui.button
                                       type="button"
                                       variant="primary-outline"
                                       size="sm"
                                      >
                                        Kartu Stok
                                    </x-ui.button>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-5 py-6 text-center text-gray-500">
                            Data tidak tersedia
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $items->links() }}
    </div>

</div>
@endsection