@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">

    <h2 class="mb-6 text-title-md2 font-semibold text-gray-800 dark:text-white/90">
        Detail Handover
    </h2>

    <!-- Info -->
    <div class="mb-6 grid grid-cols-1 gap-6 md:grid-cols-3">
        <div class="card">No: {{ $handover->handover_no }}</div>
        <div class="card">Sumber: {{ $handover->source }}</div>
        <div class="card">Tanggal: {{ $handover->handover_date }}</div>
    </div>

    <!-- Table -->
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="max-w-full overflow-x-auto custom-scrollbar">
            <table class="w-full min-w-[900px]">
                <thead>
                    <tr class="border-b border-gray-100 dark:border-gray-800">
                        <th class="th">SKU</th>
                        <th class="th">Nama</th>
                        <th class="th">Qty</th>
                        <th class="th">Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($handover->handoverItems as $item)
                    <tr class="border-b border-gray-100 dark:border-gray-800">
                        <td class="td">{{ $item->sku }}</td>
                        <td class="td">{{ $item->item_name }}</td>
                        <td class="td">{{ $item->quantity }}</td>
                        <td class="td">Rp {{ number_format($item->price) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
