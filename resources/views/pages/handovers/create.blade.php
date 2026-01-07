@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10"
     x-data="handoverForm()">

    <h2 class="mb-6 text-title-md2 font-semibold text-gray-800 dark:text-white/90">
        Tambah Handover (Barang Masuk)
    </h2>

    <form method="POST" action="{{ route('warehouse.handovers.store') }}">
        @csrf

        <!-- Header -->
        <div class="mb-6 grid grid-cols-1 gap-6 md:grid-cols-3">
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                    No Handover
                </label>
                <input type="text" name="handover_no" required
                    class="w-full rounded-lg border-gray-300 bg-white px-4 py-2
                           dark:border-gray-700 dark:bg-gray-800 dark:text-white">
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Sumber
                </label>
                <input type="text" name="source" required
                    class="w-full rounded-lg border-gray-300 bg-white px-4 py-2
                           dark:border-gray-700 dark:bg-gray-800 dark:text-white">
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Tanggal
                </label>
                <input type="date" name="handover_date" required
                    class="w-full rounded-lg border-gray-300 bg-white px-4 py-2
                           dark:border-gray-700 dark:bg-gray-800 dark:text-white">
            </div>
        </div>

        <!-- Items -->
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="p-4">
                <h3 class="mb-4 font-semibold text-gray-800 dark:text-white/90">
                    Daftar Barang Masuk
                </h3>

                <template x-for="(item, index) in items" :key="index">
                    <div class="mb-4 grid grid-cols-5 gap-4">
                        <input type="text" :name="`items[${index}][sku]`" placeholder="SKU" required class="input">
                        <input type="text" :name="`items[${index}][item_name]`" placeholder="Nama Barang" required class="input">
                        <input type="number" :name="`items[${index}][quantity]`" placeholder="Qty" required class="input">
                        <input type="number" :name="`items[${index}][price]`" placeholder="Harga" required class="input">

                        <button type="button" @click="remove(index)"
                            class="rounded-lg bg-red-500 px-3 text-white">
                            ✕
                        </button>
                    </div>
                </template>

                <button type="button" @click="add()"
                    class="rounded-lg bg-primary px-4 py-2 text-white">
                    + Tambah Item
                </button>
            </div>
        </div>

        <!-- Submit -->
        <div class="mt-6 flex justify-end">
            <button type="submit"
                class="rounded-lg bg-primary px-6 py-2 text-white hover:bg-primary/90">
                Simpan Handover
            </button>
        </div>
    </form>
</div>

<script>
function handoverForm() {
    return {
        items: [{}],
        add() { this.items.push({}) },
        remove(i) { this.items.splice(i,1) }
    }
}
</script>
@endsection
