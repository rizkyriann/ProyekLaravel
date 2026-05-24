<?php

namespace App\Http\Controllers;

use App\Models\Handover;
use App\Models\HandoverItem;
use App\Models\Item;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HandoverController extends Controller
{
    public function index()
    {
        $handovers = Handover::with('handoverItems')
            ->latest()
            ->get();

        return view('pages.handovers.index', compact('handovers'));
    }

    public function create()
    {
        return view('pages.handovers.create', [
            'handoverNo' => $this->generateHandoverNo()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'source' => 'required|string|max:150',
            'handover_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.item_name' => 'required|string|max:150',
            'items.*.sku' => 'required|string|max:50|distinct',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        try {
            DB::transaction(function () use ($data) {
                foreach ($data['items'] as $item) {
                    if (Item::where('sku', $item['sku'])->exists() || HandoverItem::where('sku', $item['sku'])->exists()) {
                        throw new \Exception("SKU {$item['sku']} sudah terdaftar");
                    }
                }

                $handover = Handover::create([
                    'handover_no' => $this->generateHandoverNo(),
                    'source' => $data['source'],
                    'handover_date' => $data['handover_date'],
                    'total_items' => count($data['items']),
                    'status' => 'draft',
                ]);

                foreach ($data['items'] as $itemData) {
                    $handover->handoverItems()->create([
                        'sku' => $itemData['sku'],
                        'item_name' => $itemData['item_name'],
                        'quantity' => $itemData['quantity'],
                        'price' => $itemData['price'],
                    ]);
                }
            });

        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }

        return redirect()
            ->route('warehouse.handovers.index')
            ->with('success', 'Handover draft berhasil dibuat');
    }

    public function confirm(Handover $handover)
    {
        if ($handover->status !== 'draft') {
            return back()->withErrors('Handover tidak bisa dikonfirmasi');
        }

        try {
            DB::transaction(function () use ($handover) {
                foreach ($handover->handoverItems as $detail) {
                    if (Item::where('sku', $detail->sku)->exists()) {
                        throw new \Exception("SKU {$detail->sku} sudah terdaftar");
                    }

                    Item::create([
                        'handover_id' => $handover->id,
                        'handover_item_id' => $detail->id,
                        'sku' => $detail->sku,
                        'name' => $detail->item_name,
                        'quantity' => $detail->quantity,
                        'price' => $detail->price,
                        'status' => 'active',
                    ]);
                }

                $handover->update([
                    'status' => 'confirmed'
                ]);
            });

        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'Handover berhasil dikonfirmasi');
    }

    public function cancel(Handover $handover)
    {
        if ($handover->status === 'cancelled') {
            return back()->withErrors('Handover sudah dibatalkan');
        }

        DB::transaction(function () use ($handover) {
            if ($handover->status === 'confirmed') {
                Item::where('handover_id', $handover->id)->delete();
            }

            $handover->update([
                'status' => 'cancelled'
            ]);
        });

        return back()->with('success', 'Handover berhasil dibatalkan');
    }

    public function show(Handover $handover)
    {
        $handover->load([
            'handoverItems',
            'stockItems'
        ]);

        return view('pages.handovers.show', compact('handover'));
    }

    public function edit(Handover $handover)
    {
        return view('pages.handovers.edit', compact('handover'));
    }

    public function update(Request $request, Handover $handover)
    {
        $data = $request->validate([
            'source' => 'required|string|max:150',
            'handover_date' => 'required|date',
        ]);

        $handover->update($data);

        return redirect()
            ->route('warehouse.handovers.index')
            ->with('success', 'Handover berhasil diupdate');
    }

    public function destroy(Handover $handover)
    {
        if ($handover->status === 'confirmed') {
            return back()->with('error', 'Handover confirmed harus dibatalkan dulu sebelum dihapus');
        }

        if ($handover->status === 'draft') {
            $handover->handoverItems()->delete();
        }

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
