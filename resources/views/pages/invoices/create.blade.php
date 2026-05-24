@extends('layouts.app')

@section('content')
<div class="page-shell"
     x-data="invoiceForm({{ $items->toJson() }})">

    <!-- Title -->
    <div class="page-header">
        <div>
            <h2 class="page-title">Buat Invoice</h2>
            <p class="page-subtitle">Pilih barang dari stok aktif. Total dihitung otomatis dari harga dan quantity.</p>
        </div>
        <a href="{{ route('warehouse.invoices.index') }}" class="table-action">Kembali</a>
    </div>

    <form method="POST" action="{{ route('warehouse.invoices.store') }}" class="space-y-5">
        @csrf

        <!-- HEADER CARD -->
        <div class="ui-card ui-card-body">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
                <div>
                    <label class="form-label">Invoice No</label>
                    <input class="input cursor-not-allowed bg-slate-100"
                           name="invoice_no"
                           value="{{ $invoiceNo }}"
                           readonly>
                </div>

                <div>
                    <label class="form-label">Tanggal</label>
                    <input type="date"
                           name="date"
                           class="input"
                           value="{{ old('date', now()->format('Y-m-d')) }}"
                           required>
                </div>

                <div class="md:col-span-2">
                    <label class="form-label">Customer</label>
                    <input class="input"
                           name="customer"
                           placeholder="Nama customer"
                           required>
                </div>

            </div>
        </div>

        <!-- ITEMS -->
        <div class="ui-card ui-card-body">
            <h3 class="mb-4 text-lg font-bold text-slate-900">
                Barang Keluar
            </h3>

            <template x-for="(row, index) in rows" :key="index">
                <div class="mb-4 rounded-2xl border border-slate-200 bg-slate-50 p-3 sm:p-4">
                    <div class="grid grid-cols-1 gap-3 md:grid-cols-7 md:items-center">

                        <!-- SEARCHABLE ITEM -->
                        <div class="relative md:col-span-2" @click.outside="row.open = false">
                            <input
                                type="text"
                                class="input input-sm"
                                placeholder="Cari barang..."
                                x-model="row.search"
                                @focus="row.open = true"
                                @input="row.open = true"
                                autocomplete="off">

                            <!-- Dropdown -->
                            <div x-show="row.open"
                                 x-transition
                                 class="absolute z-30 mt-1 max-h-60 w-full overflow-auto
                                         rounded-xl border border-slate-200 bg-white shadow-lg">

                                <template x-for="item in filteredItems(row.search)" :key="item.id">
                                    <div
                                        @click="
                                            row.item_id = item.id;
                                            row.search = item.name;
                                            row.open = false;
                                            updateItem(row)
                                        "
                                        class="cursor-pointer px-3 py-2 text-sm hover:bg-brand-25">
                                        <div class="font-semibold text-slate-900">
                                            <span x-text="item.name"></span>
                                        </div>
                                        <div class="text-xs text-slate-500 gap-6">
                                            Stok: <span x-text="item.quantity"></span>
                                            SKU: <span x-text="item.sku"></span>
                                        </div>
                                    </div>
                                </template>

                                <div x-show="filteredItems(row.search).length === 0"
                                     class="px-3 py-2 text-sm text-slate-500">
                                    Barang tidak ditemukan
                                </div>
                            </div>

                            <!-- Hidden input -->
                            <input type="hidden"
                                   :name="`items[${index}][item_id]`"
                                   x-model="row.item_id"
                                   required>
                        </div>

                        <!-- QTY -->
                        <div>
                            <input type="number"
                               min="1"
                               :max="row.maxQty"
                               :disabled="!row.item_id"
                               class="input input-sm"
                               placeholder="Quantity"
                               x-model.number="row.qty"
                               :name="`items[${index}][quantity]`"
                               @input="calc()"
                               required>
                            <p x-show="row.hasStockError" class="mt-1 text-xs text-red-500">
                                Quantity melebihi stok tersedia
                            </p>
                        </div>

                        <!-- STOCK -->
                        <div class="rounded-xl bg-white px-3 py-2 text-center text-sm font-bold text-slate-700 ring-1 ring-slate-200">
                            <span x-text="row.stock"></span>
                        </div>

                        <!-- PRICE -->
                        <div class="rounded-xl bg-white px-3 py-2 text-sm text-slate-700 ring-1 ring-slate-200">
                            <input
                                type="number"
                                min="0"
                                class="input input-sm text-center"
                                x-model.number="row.price"
                                readonly
                                @input="calc()"
                                placeholder="Harga"
                            >
                        </div>

                        <!-- SUBTOTAL -->
                        <div class="rounded-xl bg-brand-50 px-3 py-2 text-center text-sm font-bold text-brand-700 ring-1 ring-brand-100">
                            <span x-text="rupiah(row.subtotal)"></span>
                        </div>

                        <!-- DELETE -->
                        <button type="button"
                                @click="remove(index)"
                                class="btn-danger h-10 w-10 px-0">
                            x
                        </button>
                    </div>
                </div>
            </template>

            <button type="button"
                    @click="add()"
                    class="table-action">
                + Tambah Barang
            </button>
        </div>

        <!-- SUMMARY -->
        <div class="mt-6 flex justify-end">
            <div class="w-full max-w-md rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                <div class="flex justify-between text-sm mb-3 text-slate-500">
                    <span>Subtotal</span>
                    <span x-text="rupiah(subtotal)"></span>
                </div>

                <hr class="my-4 border-slate-200">

                <div class="flex justify-between text-lg font-bold text-slate-900">
                    <span>Total</span>
                    <span x-text="rupiah(total)"></span>
                </div>
            </div>
        </div>

        <!-- SUBMIT -->
        <div class="mt-6 flex justify-end">
            <button
                class="inline-flex min-h-11 items-center justify-center rounded-xl bg-brand-500 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-600 disabled:cursor-not-allowed disabled:opacity-50"
                :disabled="!canSubmit">
                Simpan Invoice
            </button>
        </div>
    </form>
</div>

<!-- ALPINE -->
<script>
function invoiceForm(items) {
    return {
        items,

        rows: [{
            item_id: '',
            search: '',
            open: false,
            qty: '',
            price: 0,
            stock: 0,
            subtotal: 0,
            maxQty: 1,
            hasStockError: false
        }],

        subtotal: 0,
        total: 0,

        get canSubmit() {
            return this.rows.length > 0
                && this.rows.every(row => row.item_id && row.qty >= 1 && row.qty <= row.maxQty)
        },

        add() {
            this.rows.push({
                item_id: '',
                search: '',
                open: false,
                qty: '',
                price: 0,
                stock: 0,
                subtotal: 0,
                maxQty: 1,
                hasStockError: false
            })
        },

        remove(i) {
            this.rows.splice(i, 1)
            this.calc()
        },

        updateItem(row) {
            const item = this.items.find(i => i.id == row.item_id)
            row.price = item ? item.price : 0
            row.stock = item ? item.quantity : 0
            row.maxQty = row.stock
            row.qty = ''
            row.hasStockError = false
            this.calc()
        },

        filteredItems(keyword) {
            if (!keyword) return this.items.slice(0, 20)

            keyword = keyword.toLowerCase()
            return this.items
                .filter(item =>
                    item.name.toLowerCase().includes(keyword)
                    || item.sku.toLowerCase().includes(keyword)
                )
                .slice(0, 20)
        },

        calc() {
            this.subtotal = 0
            this.rows.forEach(r => {
                r.subtotal = r.qty * r.price
                this.subtotal += r.subtotal
                r.hasStockError = r.item_id && r.qty > r.maxQty
            })
            this.total = this.subtotal
        },

        rupiah(val) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(val || 0)
        }
    }
}
</script>
@endsection
