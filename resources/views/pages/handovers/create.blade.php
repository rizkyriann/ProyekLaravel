@extends('layouts.app')

@section('content')
<div
    class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10"
    x-data="handoverForm()"
>

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
                <div class="mb-3 grid grid-cols-7 gap-3 items-center">

                    <!-- SKU -->
                    <div class="col-span-1">
                        <input
                            type="text"
                            :name="`items[${index}][sku]`"
                            x-model="row.sku"
                            placeholder="SKU"
                            class="input px-3 w-full text-gray-800 dark:text-white/90 bg-transparent"
                            required
                            @input="
                                row.sku = row.sku.toUpperCase().replace(/\s+/g,'');
                                checkSku(index)
                            "
                        >
                        <p
                            x-show="row.skuError"
                            class="mt-1 text-xs text-red-500"
                        >
                            SKU sudah digunakan
                        </p>
                    </div>

                    <!-- NAMA BARANG -->
                    <input
                        type="text"
                        :name="`items[${index}][item_name]`"
                        placeholder="  Nama Barang"
                        class="input col-span-2 text-gray-800 dark:text-white/90 bg-transparent"
                        x-model="row.name"
                        required
                    >

                    <!-- QTY -->
                    <input
                        type="number"
                        min="1"
                        :name="`items[${index}][quantity]`"
                        placeholder="  Qty"
                        class="input text-gray-800 dark:text-white/90 bg-transparent"
                        x-model.number="row.qty"
                        @input="calc()"
                        required
                    >

                    <!-- HARGA -->
                    <input
                        type="number"
                        min="0"
                        :name="`items[${index}][price]`"
                        placeholder="  Harga"
                        class="input text-gray-800 dark:text-white/90 bg-transparent"
                        x-model.number="row.price"
                        @input="calc()"
                        required
                    >

                    <!-- SUBTOTAL -->
                    <div class="text-sm font-semibold text-gray-800 dark:text-gray-400">
                        <span x-text="rupiah(row.subtotal)"></span>
                    </div>

                    <!-- DELETE -->
                    <button
                        type="button"
                        @click="remove(index)"
                        class="h-8 w-30 text-sm rounded-md bg-red-500 text-white flex items-center justify-center"
                    >
                        Hapus Item
                    </button>
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
        rows: [
            {
                sku: '',
                skuError: false,
                name: '',
                qty: '',
                price: '',
                subtotal: 0
            }
        ],
        total: 0,

        add() {
            this.rows.push({
                sku: '',
                skuError: false,
                name: '',
                qty: '',
                price: '',
                subtotal: 0
            })
        },

        remove(index) {
            this.rows.splice(index, 1)
            this.calc()
        },

        calc() {
            this.total = 0
            this.rows.forEach(row => {
                row.subtotal = (row.qty || 0) * (row.price || 0)
                this.total += row.subtotal
            })
        },

        async checkSku(index) {
            const sku = this.rows[index].sku
            if (!sku) return

            try {
                const res = await fetch(
                    `{{ route('warehouse.warehouse.check-sku') }}?sku=${sku}`
                )
                const data = await res.json()
                this.rows[index].skuError = data.exists
            } catch (e) {
                console.error(e)
                this.rows[index].skuError = false
            }
        },

        get hasSkuError() {
            return this.rows.some(row => row.skuError === true)
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
