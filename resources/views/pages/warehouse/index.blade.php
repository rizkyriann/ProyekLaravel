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
            class="w-full md:w-1/3 rounded-lg border px-4 py-2 font-medium text-gray-500 dark:text-gray-400 px-5 py-2
                   placeholder-gray-400 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary dark:bg-gray-800 dark:border-gray-700"
        >
    </form>

    <!-- Table -->
    <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-gray-800">
        <table class="w-full border-collapse bg-white dark:bg-gray-900">
            <thead>
                <tr class="bg-gray-100 dark:bg-gray-800 text-center sm:px-6">
                    <th class="font-medium text-gray-500 dark:text-gray-400 px-5 py-2">SKU</th>
                    <th class="font-medium text-gray-500 dark:text-gray-400 px-5 py-2">Nama Barang</th>
                    <th class="font-medium text-gray-500 dark:text-gray-400 px-5 py-2">Tanggal Masuk</th>
                    <th class="font-medium text-gray-500 dark:text-gray-400 px-5 py-2">Stok</th>
                    <th class="font-medium text-gray-500 dark:text-gray-400 px-5 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($items as $item)
                    <tr class="border-t dark:border-gray-800 text-center">
                        <td class="px-5 py-4 text-sm">
                            {{ $item->sku }}
                        </td>
                        <td class="px-5 py-4 text-sm text-center">
                            {{ $item->name }}
                        </td>
                        <td class="px-5 py-4 text-sm text-center">
                            {{ \Carbon\Carbon::parse($item->handover->handover_date)->format('d-m-Y') }}
                        </td>
                        <td class="px-5 py-4 text-sm text-center font-semibold">
                            {{ $item->quantity }}
                        </td>
                        <td class="px-5 py-4 text-center">
                            <a href="{{ route('warehouse.items.show', $item->id) }}"
                            class="inline-flex items-center justify-center rounded-md bg-primary px-2 py-1
                                    text-gray-800 hover:bg-primary/90 dark:text-white/90">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                    <path fill-rule="evenodd" d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 0 0-.673-.05A3 3 0 0 0 15 1.5h-1.5a3 3 0 0 0-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6ZM13.5 3A1.5 1.5 0 0 0 12 4.5h4.5A1.5 1.5 0 0 0 15 3h-1.5Z" clip-rule="evenodd" />
                                    <path fill-rule="evenodd" d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V9.375ZM6 12a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V12Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75ZM6 15a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V15Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75ZM6 18a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V18Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd" />
                                </svg>
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
