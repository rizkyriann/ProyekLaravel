@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10"
     x-data="invoiceForm({{ $items->toJson() }})">

    <!-- Title -->
    <h2 class="mb-6 text-title-md2 font-semibold text-gray-800 dark:text-white/90">
        Buat Invoice
    </h2>

    <form method="POST" action="{{ route('warehouse.invoices.store') }}">
        @csrf

        <!-- HEADER CARD -->
        <div class="mb-6 rounded-xl border border-gray-200 bg-white p-5 shadow-sm
                    dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
                <div>
                    <label class="mb-1 block text-sm text-gray-500">Invoice No</label>
                    <input class="input bg-gray-100 dark:bg-gray-800"
                           name="invoice_no"
                           value="{{ $invoiceNo }}"
                           readonly>
                </div>

                <div>
                    <label class="mb-1 block text-sm text-gray-500">Tanggal</label>
                    <input type="date"
                           name="date"
                           class="input"
                           value="{{ old('date', now()->format('Y-m-d')) }}"
                           required>
                </div>

                <div class="md:col-span-2">
                    <label class="mb-1 block text-sm text-gray-500">Customer</label>
                    <input class="input"
                           name="customer"
                           placeholder="Nama customer"
                           required>
                </div>

                <input type="hidden" name="total" :value="total">
            </div>
        </div>

        <!-- ITEMS -->
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm
                    dark:border-gray-800 dark:bg-white/[0.03]">
            <h3 class="mb-4 font-semibold text-gray-800 dark:text-white/90">
                Barang Keluar
            </h3>

            <template x-for="(row, index) in rows" :key="index">
                <div class="mb-3 rounded-lg border border-gray-100 p-3 dark:border-gray-700">
                    <div class="grid grid-cols-1 gap-3 md:grid-cols-7 md:items-center">

                        <!-- SEARCHABLE ITEM -->
                        <div class="relative md:col-span-2" @click.outside="row.open = false">
                            <input
                                type="text"
                                class="input"
                                placeholder="Cari barang..."
                                x-model="row.search"
                                @focus="row.open = true"
                                @input="row.open = true"
                                autocomplete="off">

                            <!-- Dropdown -->
                            <div x-show="row.open"
                                 x-transition
                                 class="absolute z-30 mt-1 max-h-60 w-full overflow-auto
                                        rounded-lg border border-gray-200 bg-white shadow-lg
                                        dark:border-gray-700 dark:bg-gray-800">

                                <template x-for="item in filteredItems(row.search)" :key="item.id">
                                    <div
                                        @click="
                                            row.item_id = item.id;
                                            row.search = item.name;
                                            row.open = false;
                                            updateItem(row)
                                        "
                                        class="cursor-pointer px-3 py-2 text-sm
                                               hover:bg-primary/10
                                               dark:hover:bg-primary/20">
                                        <div class="font-medium text-gray-800 dark:text-white">
                                            <span x-text="item.name"></span>
                                        </div>
                                        <div class="text-xs text-gray-500 gap-6">
                                            Stok: <span x-text="item.quantity"></span>
                                            SKU: <span x-text="item.sku"></span>
                                        </div>
                                    </div>
                                </template>

                                <div x-show="filteredItems(row.search).length === 0"
                                     class="px-3 py-2 text-sm text-gray-500">
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
                        <input type="number"
                               style="px-3 py-2"
                               min="1"
                               :max="row.maxQty"
                               :disabled="!row.item_id"
                               class="input"
                               placeholder="Quantity"
                               x-model.number="row.qty"
                               :name="`items[${index}][quantity]`"
                               @input="calc()"
                               required>

                        <!-- STOCK -->
                        <div class="rounded-md bg-gray-100 px-3 py-2 text-sm text-gray-700
                                    dark:bg-gray-800 dark:text-gray-300 text-center">
                            <span x-text="row.stock"></span>
                        </div>

                        <!-- PRICE -->
                        <div class="rounded-md px-3 py-2 text-sm text-gray-700
                                    dark:bg-gray-800 dark:text-gray-300">
                            <input
                                type="number"
                                min="0"
                                class="input text-right"
                                x-model.number="row.price"
                                :name="`items[${index}][price]`"
                                @input="calc()"
                                placeholder="Harga"
                            >
                        </div>

                        <!-- SUBTOTAL -->
                        <div class="rounded-md bg-primary/10 px-3 py-2 text-sm font-semibold text-primary">
                            <span x-text="rupiah(row.subtotal)"></span>
                        </div>

                        <!-- DELETE -->
                        <button type="button"
                                @click="remove(index)"
                                class="h-9 w-9 rounded-md bg-red-500/10 text-red-600
                                       hover:bg-red-500 hover:text-white transition
                                       flex items-center justify-center">
                            ✕
                        </button>
                    </div>
                </div>
            </template>

            <button type="button"
                    @click="add()"
                    class="mt-4 rounded-lg bg-primary px-4 py-2 text-sm font-medium text-white">
                + Tambah Barang
            </button>
        </div>

        <!-- SUMMARY -->
        <div class="mt-6 flex justify-end">
            <div class="w-full max-w-md rounded-xl border border-gray-200 bg-white p-5 shadow-sm
                        dark:border-gray-800 dark:bg-white/[0.03]">

                <div class="flex justify-between text-sm mb-3 dark:text-gray-400">
                    <span>Subtotal</span>
                    <span x-text="rupiah(subtotal)"></span>
                </div>

                <div class="flex justify-between items-center text-sm mb-3 dark:text-gray-400">
                    <span>Diskon</span>
                    <input type="number"
                           x-model.number="discount"
                           @input="calc()"
                           class="input w-32 text-right"
                           placeholder="0">
                </div>

                <div class="flex justify-between items-center text-sm mb-3 dark:text-gray-400">
                    <span>Shipping</span>
                    <input type="number"
                           x-model.number="shipping"
                           @input="calc()"
                           class="input w-32 text-right"
                           placeholder="0">
                </div>

                <hr class="my-4 dark:border-gray-700">

                <div class="flex justify-between text-lg font-semibold text-gray-800 dark:text-white">
                    <span>Total</span>
                    <span x-text="rupiah(total)"></span>
                </div>
            </div>
        </div>

        <!-- SUBMIT -->
        <div class="mt-6 flex justify-end">
            <button class="rounded-lg bg-primary px-6 py-2 text-white">
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
            maxQty: 1
        }],

        discount: 0,
        shipping: 0,
        subtotal: 0,
        total: 0,

        add() {
            this.rows.push({
                item_id: '',
                search: '',
                open: false,
                qty: '',
                price: 0,
                stock: 0,
                subtotal: 0,
                maxQty: 1
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
            this.calc()
        },

        filteredItems(keyword) {
            if (!keyword) return this.items.slice(0, 20)

            keyword = keyword.toLowerCase()
            return this.items
                .filter(item =>
                    item.name.toLowerCase().includes(keyword)
                )
                .slice(0, 20)
        },

        calc() {
            this.subtotal = 0
            this.rows.forEach(r => {
                r.subtotal = r.qty * r.price
                this.subtotal += r.subtotal
            })
            this.total = this.subtotal - this.discount + this.shipping
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
