@extends('layouts.app')

@section('title', 'Edit Handover')

@section('content')
<div class="mx-auto max-w-7xl">

    {{-- Header --}}
    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">
            Edit Handover
        </h2>

        {{-- Status Badge --}}
        @php
            $statusColor = match($handover->status) {
                'draft' => 'bg-yellow-100 text-yellow-800',
                'confirmed' => 'bg-green-100 text-green-800',
                'cancelled' => 'bg-red-100 text-red-800',
            };
        @endphp

        <span class="inline-flex rounded-full px-3 py-1 text-sm font-medium {{ $statusColor }}">
            {{ ucfirst($handover->status) }}
        </span>
    </div>

    <form action="{{ route('warehouse.handovers.update', $handover->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Card: Handover Info --}}
        <div class="mb-6 rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">

                {{-- Handover No --}}
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-800 dark:text-gray-300">
                        Handover No
                    </label>
                    <input
                        type="text"
                        class="w-full h-8 rounded-lg border-gray-300 bg-gray-100 text-gray-600 dark:text-gray-300 dark:border-gray-700 dark:bg-gray-800"
                        value="   {{ $handover->handover_no }}"
                        disabled
                    >
                </div>

                {{-- Supplier --}}
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Supplier
                    </label>
                    <input
                        type="text"
                        name="source"
                        value="   {{ old('source', $handover->source) }}"
                        class="w-full h-8 rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300"
                        {{ $handover->status !== 'draft' ? 'readonly' : '' }}
                    >
                </div>

                {{-- Status --}}
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Tanggal Handover
                    </label>
                    <input
                        type="text"
                        name="handover_date"
                        value="   {{ old('handover_date', $handover->handover_date) }}"
                        class="w-full h-8 rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300"
                        {{ $handover->status !== 'draft' ? 'readonly' : '' }}
                    >
                </div>

            </div>
        </div>

        {{-- Card: Items --}}
        <div class="mb-6 rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
            <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
                <h3 class="text-base font-semibold text-gray-800 dark:text-white">
                    Daftar Barang
                </h3>
            </div>

            <div class="p-6 space-y-4">
                @foreach($handover->handoverItems as $index => $item)
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-12">

                        {{-- Item Name --}}
                        <div class="md:col-span-4">
                            <label class="mb-1 block text-sm text-gray-600 dark:text-gray-400">
                                Nama Barang
                            </label>
                            <input
                                type="text"
                                name="items[{{ $index }}][item_name]"
                                value="   {{ $item->name }}"
                                class="w-full h-10 rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300"
                                {{ $handover->status !== 'draft' ? 'readonly' : '' }}
                            >
                        </div>

                        {{-- SKU --}}
                        <div class="md:col-span-2">
                            <label class="mb-1 block text-sm text-gray-600 dark:text-gray-400">
                                SKU
                            </label>
                            <input
                                type="text"
                                value="   {{ $item->sku }}"
                                class="w-full h-10 rounded-lg border-gray-300 bg-gray-100 text-gray-600 dark:border-gray-700 dark:bg-gray-800"
                                readonly
                            >
                        </div>

                        {{-- Quantity --}}
                        <div class="md:col-span-3">
                            <label class="mb-1 block text-sm text-gray-600 dark:text-gray-400">
                                Quantity
                            </label>
                            <input
                                type="number"
                                name="items[{{ $index }}][quantity]"
                                value="{{ $item->quantity }}"
                                class="w-full px-3 h-10 rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400"
                                {{ $handover->status !== 'draft' ? 'readonly' : '' }}
                            >
                        </div>

                        {{-- Price --}}
                        <div class="md:col-span-3">
                            <label class="mb-1 block text-sm text-gray-600 dark:text-gray-400">
                                Harga
                            </label>
                            <input
                                type="number"
                                name="items[{{ $index }}][price]"
                                value="{{ $item->price }}"
                                class="w-full h-10 px-3 rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400"
                                {{ $handover->status !== 'draft' ? 'readonly' : '' }}
                            >
                        </div>

                    </div>
                @endforeach

                @if($handover->status !== 'draft')
                    <p class="text-sm text-gray-500">
                        Item dan harga terkunci setelah handover dikonfirmasi atau dibatalkan.
                    </p>
                @endif
            </div>
        </div>

        {{-- Action --}}
        <div class="flex items-center justify-between">
            <a
                href="{{ route('warehouse.handovers.index') }}"
                class="inline-flex items-center rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800"
            >
                Kembali
            </a>

            @if($handover->status === 'draft')
                <button
                    type="submit"
                    class="inline-flex items-center rounded-lg bg-primary px-6 py-2 text-sm font-medium text-white hover:bg-primary/90"
                >
                    Simpan Perubahan
                </button>
            @endif
        </div>

    </form>
</div>
@endsection
