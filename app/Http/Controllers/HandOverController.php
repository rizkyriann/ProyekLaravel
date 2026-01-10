<?php

namespace App\Http\Controllers;

use App\Models\Handover;
use App\Models\Item;
use Carbon\Carbon;
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
        return view('pages.handovers.create', [
            'handoverNo' => $this->generateHandoverNo()
        ]);
    }

    // Simpan handover (STOCK IN)
    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {

            // 0. VALIDASI
            $data = $request->validate([
                'source' => 'required|string',
                'handover_date' => 'required|date',
                'items' => 'required|array|min:1',
                'items.*.item_name' => 'required|string',
                'items.*.sku' => 'required|string|distinct',
                'items.*.quantity' => 'required|integer|min:1',
                'items.*.price' => 'required|numeric|min:0',
            ]);

            $handoverNo = $this->generateHandoverNo();

            // 1. SIMPAN HANDOVER (HEADER)
            $handover = Handover::create([
                'handover_no'   => $handoverNo,
                'source'        => $data['source'], // supplier
                'handover_date' => $data['handover_date'],
                'status'        => 'completed',
            ]);

            // 2. SIMPAN HANDOVER ITEMS + MASUK STOK
            foreach ($data['items'] as $itemData) {

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

                // Mencegah dupliaksi SKU
                if (Item::where('sku', $itemData['sku'])->exists()) {
                    return back()
                        ->withErrors(['SKU' => "SKU {$itemData['sku']} sudah terdaftar"])
                        ->withInput();
                }
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

    private function generateHandoverNo()
    {
        $date = Carbon::now()->format('Ym');

        $last = Handover::where('handover_no', 'like', "HO-$date%")
            ->latest('id')
            ->first();

        $number = $last
            ? intval(substr($last->handover_no, -4)) + 1
            : 1;

        return "HO-$date-" . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

}
