@extends('layouts.app')

@section('content')
<div class="page-shell">

    <div class="page-header">
        <div>
            <h2 class="page-title">Stok Gudang</h2>
            <p class="page-subtitle">Pantau jumlah stok aktif, tanggal masuk, dan detail barang gudang.</p>
        </div>
    </div>

    <!-- Search -->
    <form method="GET" class="ui-card ui-card-body">
        <input
            type="text"
            name="q"
            value="{{ request('q') }}"
            placeholder="Cari SKU / Nama Barang..."
            class="input max-w-xl"
        >
    </form>

    <!-- Table -->
    <div class="table-card">
        <div class="table-scroll">
        <table class="min-w-[840px]">
            <thead>
                <tr>
                    <th class="w-12 text-center">No</th>
                    <th>SKU</th>
                    <th>Nama Barang</th>
                    <th>Tanggal Masuk</th>
                    <th class="text-center">Stok</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($items as $item)
                    <tr>
                        <td class="text-center">
                            {{ $items->firstItem() + $loop->index }}
                        </td>
                        <td class="font-semibold text-slate-900">
                            {{ $item->sku }}
                        </td>
                        <td>
                            {{ $item->name }}
                        </td>
                        <td>
                            {{ optional($item->handover)->handover_date ? \Carbon\Carbon::parse($item->handover->handover_date)->format('d M Y') : '-' }}
                        </td>
                        <td class="text-center">
                            <span class="inline-flex min-w-12 justify-center rounded-full bg-brand-50 px-3 py-1 text-sm font-bold text-brand-700 ring-1 ring-brand-100">
                            {{ $item->quantity }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-center">
                            <a href="{{ route('warehouse.items.show', $item->id) }}"
                            class="table-action-primary">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-10 text-center text-sm font-medium text-slate-500">
                            Data tidak ditemukan
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $items->links() }}
    </div>

</div>
@endsection
