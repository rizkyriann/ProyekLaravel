<?php

namespace App\Http\Controllers;

use App\Models\Handover;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HandoverController extends Controller
{
    // List handover
    public function index()
    {
        $handovers = Handover::with('handoverItems')
            ->latest()
            ->get();

        return view('pages.handovers.index', compact('handovers'));
    }

    // Form tambah handover
    public function create()
    {
        return view('pages.handovers.create');
    }

    // Simpan handover (STOCK IN)
    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {

            // 1. SIMPAN HANDOVER (HEADER)
            $handover = Handover::create([
                'handover_no'   => $request->handover_no,
                'source'        => $request->source, // supplier
                'handover_date' => $request->handover_date,
                'status'        => 'completed',
            ]);

            // 2. SIMPAN HANDOVER ITEMS + MASUK STOK
            foreach ($request->items as $itemData) {

                // detail barang masuk (dokumen)
                $handoverItem = $handover->handoverItems()->create([
                    'sku'       => $itemData['sku'],
                    'item_name' => $itemData['item_name'],
                    'quantity'  => $itemData['quantity'],
                    'price'     => $itemData['price'],
                ]);

                // stok gudang (hasil transaksi)
                Item::create([
                    'handover_id'       => $handover->id,
                    'handover_item_id'  => $handoverItem->id,
                    'sku'               => $itemData['sku'],
                    'name'              => $itemData['item_name'],
                    'quantity'          => $itemData['quantity'],
                    'price'             => $itemData['price'],
                    'status'            => 'active',
                ]);
            }
        });

        return redirect()
            ->route('warehouse.handovers.index')
            ->with('success', 'Handover berhasil dibuat');
    }

    // Detail handover
    public function show(Handover $handover)
    {
        $handover->load([
            'handoverItems',
            'stockItems'
        ]);

        return view('pages.handovers.show', compact('handover'));
    }

    // Edit handover (biasanya jarang dipakai)
    public function edit(Handover $handover)
    {
        return view('pages.handovers.edit', compact('handover'));
    }

    // Update handover (HEADER ONLY)
    public function update(Request $request, Handover $handover)
    {
        $handover->update([
            'source'        => $request->source,
            'handover_date' => $request->handover_date,
        ]);

        return redirect()
            ->route('warehouse.handovers.index')
            ->with('success', 'Handover berhasil diupdate');
    }

    // Hapus handover (soft delete disarankan)
    public function destroy(Handover $handover)
    {
        $handover->delete();

        return redirect()
            ->route('warehouse.handovers.index')
            ->with('success', 'Handover berhasil dihapus');
    }
}
