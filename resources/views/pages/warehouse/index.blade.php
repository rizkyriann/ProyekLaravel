@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">

    <h2 class="mb-6 text-title-md2 font-semibold text-gray-800 dark:text-white/90">
        Stok Gudang
    </h2>

    <!-- Search -->
    <form method="GET" class="mb-4">
        <input
            type="text"
            name="q"
            value="{{ request('q') }}"
            placeholder="Cari SKU / Nama Barang..."
            class="w-full md:w-1/3 rounded-lg border px-4 py-2 text-sm dark:bg-gray-900 dark:border-gray-700"
        >
    </form>

    <!-- Table -->
    <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-gray-800">
        <table class="w-full border-collapse bg-white dark:bg-gray-900">
            <thead>
                <tr class="bg-gray-100 dark:bg-gray-800">
                    <th class="px-5 py-3 text-left text-sm font-medium">SKU</th>
                    <th class="px-5 py-3 text-left text-sm font-medium">Nama Barang</th>
                    <th class="px-5 py-3 text-right text-sm font-medium">Stok</th>
                    <th class="px-5 py-3 text-center text-sm font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($items as $item)
                    <tr class="border-t dark:border-gray-800">
                        <td class="px-5 py-4 text-sm">
                            {{ $item->sku }}
                        </td>
                        <td class="px-5 py-4 text-sm">
                            {{ $item->name }}
                        </td>
                        <td class="px-5 py-4 text-right text-sm font-semibold">
                            {{ $item->quantity }}
                        </td>
                        <td class="px-5 py-4 text-center">
                            <a href="{{ route('warehouse.items.show', $item->id) }}"
                               class="text-blue-600 hover:underline text-sm">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-5 py-6 text-center text-sm text-gray-500">
                            Data tidak ditemukan
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $items->links() }}
    </div>

</div>
@endsection
