@extends('layouts.app')

@section('content')
<div
    class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10"
    x-data="handoverForm()"
    x-init="init()">

    <h2 class="mb-6 text-title-md2 font-semibold text-gray-800 dark:text-white/90">
        Tambah Handover (Barang Masuk)
    </h2>

    <form method="POST" action="{{ route('warehouse.handovers.store') }}">
        @csrf

        <!-- HEADER -->
        <div class="mb-6 grid grid-cols-1 gap-6 md:grid-cols-3">

            <!-- NO HANDOVER -->
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">
                    No Handover
                </label>
                <input
                    class="input cursor-not-allowed text-gray-700 dark:text-gray-400 bg-transparent focus:border-primary focus:ring-0"
                    name="handover_no"
                    value="{{ $handoverNo }}"
                    readonly
                >
            </div>

            <!-- SUMBER -->
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">
                    Sumber / Supplier
                </label>
                <input
                    class="input text-gray-700 dark:text-gray-400 bg-transparent"
                    name="source"
                    placeholder="Sumber / Supplier"
                    required
                >
            </div>

            <!-- TANGGAL -->
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400 bg-transparent">
                    Tanggal
                </label>
                <input
                    class="input text-gray-700 dark:text-gray-400"
                    type="date"
                    name="handover_date"
                    value="{{ old('handover_date', now()->format('Y-m-d')) }}"
                    required
                >
            </div>

        </div>


        <!-- ITEMS -->
        <div class="rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.03]">
            <h3 class="mb-4 font-semibold text-gray-800 dark:text-white/90">
                Daftar Barang Masuk
            </h3>

            <template x-for="(row, index) in rows" :key="index">
                <div class="mb-4 rounded-xl border border-gray-100 bg-gray-50 p-3 dark:border-gray-800 dark:bg-gray-900/40">
                    <div class="grid grid-cols-1 gap-3 md:grid-cols-12 md:items-start">

                    <!-- SKU -->
                    <div class="md:col-span-2">
                        <label class="mb-1 block text-xs font-medium text-gray-500 dark:text-gray-400">SKU</label>
                        <input
                            type="text"
                            :name="`items[${index}][sku]`"
                            x-model="row.sku"
                            placeholder="SKU"
                            class="input px-3 w-full text-gray-800 dark:text-white/90 bg-white dark:bg-gray-950"
                            required
                            @input="
                                row.sku = row.sku.toUpperCase().replace(/\s+/g,'');
                                checkSku(index)
                            "
                        >
                        <p x-show="row.checkingSku" class="mt-1 text-xs text-gray-500">
                            Mengecek SKU...
                        </p>
                        <p
                            x-show="row.skuError"
                            class="mt-1 text-xs text-red-500"
                        >
                            SKU sudah digunakan
                        </p>
                    </div>

                    <!-- NAMA BARANG -->
                    <div class="md:col-span-4">
                        <label class="mb-1 block text-xs font-medium text-gray-500 dark:text-gray-400">Nama Barang</label>
                        <input
                            type="text"
                            :name="`items[${index}][item_name]`"
                            placeholder="Nama barang"
                            class="input w-full text-gray-800 dark:text-white/90 bg-white dark:bg-gray-950"
                            x-model="row.name"
                            required
                        >
                    </div>

                    <!-- QTY -->
                    <div class="md:col-span-2">
                        <label class="mb-1 block text-xs font-medium text-gray-500 dark:text-gray-400">Qty</label>
                        <input
                            type="number"
                            min="1"
                            :name="`items[${index}][quantity]`"
                            placeholder="Qty"
                            class="input w-full text-gray-800 dark:text-white/90 bg-white dark:bg-gray-950"
                            x-model.number="row.quantity"
                            @input="calc()"
                            required
                        >
                    </div>

                    <!-- HARGA -->
                    <div class="md:col-span-2">
                        <label class="mb-1 block text-xs font-medium text-gray-500 dark:text-gray-400">Harga</label>
                        <input
                            type="number"
                            min="0"
                            :name="`items[${index}][price]`"
                            placeholder="Harga"
                            class="input w-full text-gray-800 dark:text-white/90 bg-white dark:bg-gray-950"
                            x-model.number="row.price"
                            @input="calc()"
                            required
                        >
                    </div>

                    <!-- SUBTOTAL -->
                    <div class="md:col-span-1 text-sm font-semibold text-gray-800 dark:text-gray-400">
                        <label class="mb-1 block text-xs font-medium text-gray-500 dark:text-gray-400">Subtotal</label>
                        <span x-text="rupiah(row.subtotal)"></span>
                    </div>

                    <!-- DELETE -->
                    <button
                        type="button"
                        @click="remove(index)"
                        class="md:col-span-1 h-10 rounded-lg bg-red-500 px-3 text-sm text-white hover:bg-red-600"
                    >
                        Hapus
                    </button>
                    </div>
                </div>
            </template>

            <x-ui.button
                type="button"
                size="sm"
                variant="outline"
                @click="add()"
            >
                + Tambah Item
            </x-ui.button>

        </div>

        <div class="text-sm font-semibold text-gray-800 dark:text-gray-400">
                *) Kode SKU (3 Huruf-3 Angka), Jika SKU sudah digunakan, silakan ganti dengan SKU lain.
        </div>
        <!-- SUMMARY -->
        <div class="mt-6 max-w-md ml-auto rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex justify-between font-semibold text-gray-800 dark:text-white/90">
                <span>Total Harga</span>
                <span x-text="rupiah(total)"></span>
            </div>
        </div>

        <!-- SUBMIT -->
        <div class="mt-6 flex justify-end">
            <x-ui.button
                type="submit"
                size="md"
                variant="primary"
                x-bind:disabled="hasSkuError"
                x-bind:class="{
                    'opacity-50 cursor-not-allowed': hasSkuError
                }"
                 >
                Simpan Handover
            </x-ui.button>
        </div>
    </form>
</div>

<!-- ALPINE LOGIC -->
<script>
function handoverForm() {
    return {
        rows: [],
        total: 0,
        checkSkuUrl: @json(route('warehouse.check-sku')),

        generateSku() {
            const letters = 'ABCDEFGHJKLMNPQRSTUVWXYZ'
            const numbers = '23456789'

            const randomLetters = [...Array(3)]
                .map(() => letters[Math.floor(Math.random() * letters.length)])
                .join('')

            const randomNumbers = [...Array(3)]
                .map(() => numbers[Math.floor(Math.random() * numbers.length)])
                .join('')

            return `${randomLetters}-${randomNumbers}`
        },

        init() {
            // AUTO GENERATE SKU SAAT PAGE LOAD
            if (this.rows.length === 0) {
            this.add()
            }
        },

        add() {
            this.rows.push({
                sku: this.generateSku(),
                name: '',
                quantity: 1,
                price: 0,
                subtotal: 0,
                skuError: false,
                checkingSku: false
            })

            this.checkSku(this.rows.length - 1)
        },

        remove(index) {
            this.rows.splice(index, 1)
            this.calc()
        },

        calc() {
            this.total = 0
            this.rows.forEach(row => {
                row.subtotal = (row.quantity || 0) * (row.price || 0)
                this.total += row.subtotal
            })
        },

        get hasSkuError() {
            return this.rows.length === 0 || this.rows.some(row => row.skuError || row.checkingSku)
        },

        async checkSku(index) {
            const row = this.rows[index]

            if (!row || !row.sku) {
                return
            }

            row.checkingSku = true

            try {
                const params = new URLSearchParams({ sku: row.sku })
                const response = await fetch(`${this.checkSkuUrl}?${params.toString()}`)
                const data = await response.json()
                row.skuError = Boolean(data.exists)
            } catch (error) {
                row.skuError = true
            } finally {
                row.checkingSku = false
            }
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
