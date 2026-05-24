@extends('layouts.app')

@section('content')
<div class="page-shell">

    <!-- Header -->
    <div class="page-header">
        <div>
            <h2 class="page-title">Data Handover</h2>
            <p class="page-subtitle">Kelola dokumen barang masuk sebelum dikonfirmasi menjadi stok gudang.</p>
        </div>

        <a href="{{ route('warehouse.handovers.create') }}">
            <x-ui.button size="md" variant="primary">
                Tambah Handover
            </x-ui.button>
        </a>
    </div>

    <!-- Table Wrapper -->
    <div class="table-card">
        <div class="table-scroll custom-scrollbar">
            <table class="w-full min-w-[1100px]">
                <thead>
                    <tr>
                        <th>
                            No Handover
                        </th>

                        <th>
                            Sumber
                        </th>

                        <th>
                            Tanggal
                        </th>

                        <th>
                            Jumlah Item
                        </th>

                        <th>
                            Status
                        </th>

                        <th class="w-[160px] text-center">
                            Aksi
                        </th>

                    </tr>
                </thead>

                <tbody>
                    @forelse ($handovers as $handover)
                        <tr>

                            <!-- No Handover -->
                            <td>
                                <p class="font-bold text-slate-900">
                                    {{ $handover->handover_no }}
                                </p>
                            </td>

                            <!-- Source -->
                            <td>
                                <p class="text-slate-600">
                                    {{ $handover->source }}
                                </p>
                            </td>

                            <!-- Date -->
                            <td>
                                <p class="text-slate-600">
                                    {{ \Carbon\Carbon::parse($handover->handover_date)->format('d M Y') }}
                                </p>
                            </td>

                            <!-- Total Items -->
                            <td>
                                <p class="font-semibold text-slate-700">
                                    {{ $handover->handoverItems->count() }} item
                                </p>
                            </td>

                            <!-- Status -->
                            <td>
                                <span class="status-badge status-{{ $handover->status }}">
                                    {{ ucfirst($handover->status) }}
                                </span>
                            </td>

                            <!-- Action -->
                            <td>
                                <div class="flex items-center justify-center gap-3">
                                    <!-- Detail -->
                                    <a href="{{ route('warehouse.handovers.show', $handover) }}"
                                       class="table-action">
                                        Detail
                                    </a>

                                    <!--Edit-->
                                    <a href="{{ route('warehouse.handovers.edit', $handover) }}"
                                       class="table-action-primary">
                                        Edit
                                    </a>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-10 text-center text-sm font-medium text-slate-500">
                                Data handover belum tersedia
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>

</div>
@endsection
