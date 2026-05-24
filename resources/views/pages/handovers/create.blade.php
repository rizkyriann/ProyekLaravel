@extends('layouts.app')

@section('content')
<div
    class="page-shell"
    x-data="handoverForm()"
    x-init="init()">

    <div class="page-header">
        <div>
            <h2 class="page-title">Tambah Handover</h2>
            <p class="page-subtitle">Input barang masuk sebagai draft, lalu konfirmasi saat data sudah benar.</p>
        </div>
        <a href="{{ route('warehouse.handovers.index') }}" class="table-action">Kembali</a>
    </div>

    <form method="POST" action="{{ route('warehouse.handovers.store') }}" class="space-y-5">
        @csrf

        <!-- HEADER -->
        <div class="ui-card ui-card-body grid grid-cols-1 gap-4 md:grid-cols-3">

            <!-- NO HANDOVER -->
            <div>
                <label class="form-label">
                    No Handover
                </label>
                <input
                    class="input cursor-not-allowed"
                    name="handover_no"
                    value="{{ $handoverNo }}"
                    readonly
                >
            </div>

            <!-- SUMBER -->
            <div>
                <label class="form-label">
                    Sumber / Supplier
                </label>
                <input
                    class="input"
                    name="source"
                    placeholder="Sumber / Supplier"
                    required
                >
            </div>

            <!-- TANGGAL -->
            <div>
                <label class="form-label">
                    Tanggal
                </label>
                <input
                    class="input"
                    type="date"
                    name="handover_date"
                    value="{{ old('handover_date', now()->format('Y-m-d')) }}"
                    required
                >
            </div>

        </div>


        <!-- ITEMS -->
        <div class="ui-card ui-card-body">
            <h3 class="mb-4 text-lg font-bold text-slate-900">
                Daftar Barang Masuk
            </h3>

            <template x-for="(row, index) in rows" :key="index">
                <div class="mb-4 rounded-2xl border border-slate-200 bg-slate-50 p-3 sm:p-4">
                    <div class="grid grid-cols-1 gap-3 md:grid-cols-12 md:items-start">

                    <!-- SKU -->
                    <div class="md:col-span-2">
                        <label class="form-label text-xs">SKU</label>
                        <input
                            type="text"
                            :name="`items[${index}][sku]`"
                            x-model="row.sku"
                            placeholder="SKU"
                            class="input input-sm"
                            required
                            @input="
                                row.sku = row.sku.toUpperCase().replace(/\s+/g,'');
                                checkSku(index)
                            "
                        >
                        <p x-show="row.checkingSku" class="mt-1 text-xs text-slate-500">
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
                        <label class="form-label text-xs">Nama Barang</label>
                        <input
                            type="text"
                            :name="`items[${index}][item_name]`"
                            placeholder="Nama barang"
                            class="input input-sm"
                            x-model="row.name"
                            required
                        >
                    </div>

                    <!-- QTY -->
                    <div class="md:col-span-2">
                        <label class="form-label text-xs">Qty</label>
                        <input
                            type="number"
                            min="1"
                            :name="`items[${index}][quantity]`"
                            placeholder="Qty"
                            class="input input-sm"
                            x-model.number="row.quantity"
                            @input="calc()"
                            required
                        >
                    </div>

                    <!-- HARGA -->
                    <div class="md:col-span-2">
                        <label class="form-label text-xs">Harga</label>
                        <input
                            type="number"
                            min="0"
                            :name="`items[${index}][price]`"
                            placeholder="Harga"
                            class="input input-sm"
                            x-model.number="row.price"
                            @input="calc()"
                            required
                        >
                    </div>

                    <!-- SUBTOTAL -->
                    <div class="md:col-span-1 text-sm font-semibold text-slate-800">
                        <label class="form-label text-xs">Subtotal</label>
                        <span x-text="rupiah(row.subtotal)"></span>
                    </div>

                    <!-- DELETE -->
                    <button
                        type="button"
                        @click="remove(index)"
                        class="btn-danger md:col-span-1"
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

        <div class="rounded-xl border border-brand-100 bg-brand-25 px-4 py-3 text-sm font-semibold text-brand-700">
                *) Kode SKU (3 Huruf-3 Angka), Jika SKU sudah digunakan, silakan ganti dengan SKU lain.
        </div>
        <!-- SUMMARY -->
        <div class="ml-auto max-w-md rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex justify-between text-lg font-bold text-slate-900">
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
