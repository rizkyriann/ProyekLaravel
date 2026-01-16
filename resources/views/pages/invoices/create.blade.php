@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10"
     x-data="invoiceForm({{ $items->toJson() }})">

    <h2 class="mb-6 text-title-md2 font-semibold text-gray-800 dark:text-white/90">
        Buat Invoice
    </h2>

    <form method="POST" action="{{ route('warehouse.invoices.store') }}">
        @csrf

        <!-- Header -->
        <div class="mb-6 grid grid-cols-1 gap-6 md:grid-cols-3">
            <input 
                class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400 bg-transparent"
                name="invoice_no"
                placeholder="No Invoice"
                required
            >
            <input 
                class="input"
                type="date"
                name="date"
                value="{{ old('date', now()->format('Y-m-d')) }}"
                required
            >
            <input class="input" name="customer" placeholder="Customer" required>
            <!-- total wajib dikirim -->
            <input type="hidden" name="total" :value="total">
        </div>

        <!-- Items -->
        <div class="rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.03]">
            <h3 class="mb-4 font-semibold text-gray-800 dark:text-white/90">
                Barang Keluar
            </h3>

            <template x-for="(row, index) in rows" :key="index">
                <div class="mb-3 grid grid-cols-6 gap-3 items-center">

                    <!-- Item -->
                    <select :name="`items[${index}][item_id]`"
                            class="input col-span-2"
                            x-model="row.item_id"
                            @change="updateItem(row)"
                            required>
                        <option value="">-- Pilih Barang --</option>
                        <template x-for="item in items" :key="item.id">
                            <option :value="item.id">
                                <span x-text="item.name"></span>
                                (Stok: <span x-text="item.quantity"></span>)
                            </option>
                        </template>
                    </select>

                    <!-- Qty -->
                    <input type="number"
                           min="1"
                           :max="row.maxQty"
                           class="input"
                           placeholder="Qty"
                           x-model.number="row.qty"
                           :name="`items[${index}][quantity]`"
                           @input="calc()"
                           required>

                    <!-- Harga -->
                    <div class="text-sm text-gray-600 dark:text-gray-400">
                        <span x-text="rupiah(row.price)"></span>
                    </div>

                    <!-- Subtotal -->
                    <div class="text-sm font-semibold text-gray-800 dark:text-gray-400">
                        <span x-text="rupiah(row.subtotal)"></span>
                    </div>

                    <!-- Delete -->
                    <button type="button"
                            @click="remove(index)"
                            class="h-8 w-8 rounded-md bg-red-500 text-xs text-white flex items-center justify-center">
                        ✕
                    </button>
                </div>
            </template>

            <button type="button"
                    @click="add()"
                    class="mt-3 rounded-lg bg-primary px-4 py-2 text-white">
                + Tambah Barang
            </button>
        </div>

        <!-- Summary -->
        <div class="mt-6 rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.03] max-w-md ml-auto">
            <div class="flex justify-between text-sm mb-2 dark:text-gray-400">
                <span>Subtotal</span>
                <span x-text="rupiah(subtotal)"></span>
            </div>

            <div class="flex justify-between text-sm mb-2 items-center dark:text-gray-400">
                <span>Diskon</span>
                <input type="number"
                       x-model.number="discount"
                       @input="calc()"
                       class="input w-32 text-right"
                       placeholder="0">
            </div>

            <div class="flex justify-between text-sm mb-2 items-center dark:text-gray-400">
                <span>Shipping</span>
                <input type="number"
                       x-model.number="shipping"
                       @input="calc()"
                       class="input w-32 text-right"
                       placeholder="0">
            </div>

            <hr class="my-3 dark:border-gray-700">

            <div class="flex justify-between font-semibold text-gray-800 dark:text-white/90">
                <span>Total</span>
                <span x-text="rupiah(total)"></span>
            </div>
        </div>

        <!-- Submit -->
        <div class="mt-6 flex justify-end">
            <button
                class="rounded-lg bg-primary px-6 py-2 text-white disabled:opacity-50">
                Simpan Invoice
            </button>
        </div>
    </form>
</div>

<script>
function invoiceForm(items) {
    return {
        items,

        init() {
            this.calc()
        },

        rows: [{
            item_id: '',
            qty: 1,
            price: 0,
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
                qty: 1,
                price: 0,
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
            row.maxQty = item ? item.quantity : 1

            if (row.qty > row.maxQty) {
                row.qty = row.maxQty
            }

            this.calc()
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
