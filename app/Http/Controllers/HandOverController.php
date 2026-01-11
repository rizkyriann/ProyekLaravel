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

            $data = $request->validate([
                'source' => 'required|string',
                'handover_date' => 'required|date',
                'items' => 'required|array|min:1',
                'items.*.item_name' => 'required|string',
                'items.*.sku' => 'required|string|distinct',
                'items.*.quantity' => 'required|integer|min:1',
                'items.*.price' => 'required|numeric|min:0',
            ]);

            // CEK SKU SEBELUM INSERT APA PUN
            foreach ($data['items'] as $item) {
                if (Item::where('sku', $item['sku'])->exists()) {
                    throw new \Exception("SKU {$item['sku']} sudah terdaftar");
                }
            }

            // HEADER → DRAFT
            $handover = Handover::create([
                'handover_no'   => $this->generateHandoverNo(),
                'source'        => $data['source'],
                'handover_date' => $data['handover_date'],
                'status'        => 'draft',
            ]);

            // DETAIL (DOKUMEN SAJA)
            foreach ($data['items'] as $itemData) {
                $handover->handoverItems()->create([
                    'sku'       => $itemData['sku'],
                    'item_name' => $itemData['item_name'],
                    'quantity'  => $itemData['quantity'],
                    'price'     => $itemData['price'],
                ]);
            }
        });

        return redirect()
            ->route('warehouse.handovers.index')
            ->with('success', 'Handover draft berhasil dibuat');
    }

    // Fungsi konfirmasi handover (FINAL)
    public function confirm(Handover $handover)
    {
        if ($handover->status !== 'draft') {
            return back()->withErrors('Handover tidak bisa dikonfirmasi');
        }

        DB::transaction(function () use ($handover) {

            foreach ($handover->handoverItems as $detail) {
                if (Item::where('sku', $detail->sku)->exists()) {
                    throw new \Exception("SKU {$detail->sku} sudah terdaftar");
                }
                
                Item::create([
                    'handover_id'      => $handover->id,
                    'handover_item_id' => $detail->id,
                    'sku'              => $detail->sku,
                    'name'             => $detail->item_name,
                    'quantity'         => $detail->quantity,
                    'price'            => $detail->price,
                    'status'           => 'active',
                ]);
            }

            $handover->update([
                'status' => 'confirmed'
            ]);
        });

        return back()->with('success', 'Handover berhasil dikonfirmasi');
    }

    // Ubah status cancel
    public function cancel(Handover $handover)
    {
        if ($handover->status === 'cancelled') {
            return back()->withErrors('Handover sudah dibatalkan');
        }

        DB::transaction(function () use ($handover) {

            // rollback stok JIKA sudah confirm
            if ($handover->status === 'confirmed') {
                Item::where('handover_id', $handover->id)->delete();
            }

            $handover->update([
                'status' => 'cancelled'
            ]);
        });

        return back()->with('success', 'Handover berhasil dibatalkan');
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
