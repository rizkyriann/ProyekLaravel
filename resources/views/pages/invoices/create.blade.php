@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10"
     x-data="invoiceForm()">

    <h2 class="mb-6 text-title-md2 font-semibold text-gray-800 dark:text-white/90">
        Buat Invoice
    </h2>

    <form method="POST" action="{{ route('warehouse.invoices.store') }}">
        @csrf

        <!-- Header -->
        <div class="mb-6 grid grid-cols-1 gap-6 md:grid-cols-3">
            <input class="input" name="invoice_no" placeholder="No Invoice" required>
            <input class="input" type="date" name="invoice_date" required>
            <input class="input" name="customer_name" placeholder="Customer" required>
        </div>

        <!-- Items -->
        <div class="rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.03]">
            <h3 class="mb-4 font-semibold text-gray-800 dark:text-white/90">
                Barang Keluar
            </h3>

            <template x-for="(row, index) in rows" :key="index">
                <div class="mb-4 grid grid-cols-5 gap-4">
                    <select :name="`items[${index}][item_id]`" class="input" required>
                        <option value="">-- Pilih Barang --</option>
                        @foreach($items as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->name }} (Stok: {{ $item->quantity }})
                            </option>
                        @endforeach
                    </select>

                    <input type="number"
                           :name="`items[${index}][quantity]`"
                           min="1"
                           placeholder="Qty"
                           class="input"
                           required>

                    <div></div>

                    <button type="button"
                            @click="remove(index)"
                            class="rounded-lg bg-red-500 px-3 text-white">
                        ✕
                    </button>
                </div>
            </template>

            <button type="button"
                    @click="add()"
                    class="rounded-lg bg-primary px-4 py-2 text-white">
                + Tambah Barang
            </button>
        </div>

        <div class="mt-6 flex justify-end">
            <button class="rounded-lg bg-primary px-6 py-2 text-white">
                Simpan Invoice
            </button>
        </div>
    </form>
</div>

<script>
function invoiceForm() {
    return {
        rows: [{}],
        add() { this.rows.push({}) },
        remove(i) { this.rows.splice(i,1) }
    }
}
</script>
@endsection
