<?php
namespace App\Http\Controllers;

use App\Models\HandOver;
use App\Models\HandoverItem;
use App\Models\Item;
use Illuminate\Http\Request;

class HandOverController extends Controller
{
    // Tampilkan list handover
    public function index()
    {
        $handovers = HandOver::with('items')->latest()->get();
        return view('warehouse.handovers.index', compact('handovers'));
    }

    // Form tambah handover
    public function create()
    {
        return view('warehouse.handovers.create');
    }

    // Simpan handover baru
    public function store(Request $request)
    {
        // Validasi bisa langsung di sini atau pakai FormRequest
        $handover = HandOver::create($request->all());

        // Simpan Handover Items
        foreach ($request->items as $itemData) {
            $handoverItem = $handover->items()->create($itemData);

            // Optional: otomatis masuk ke stok
            Item::create([
                'sku' => $itemData['sku'],
                'name' => $itemData['item_name'],
                'handover_id' => $handover->id,
                'quantity' => $itemData['quantity'],
                'price' => $itemData['price'],
                'status' => 'active'
            ]);
        }

        return redirect()->route('handovers.index')->with('success', 'Handover berhasil dibuat.');
    }

    // Tampilkan detail handover
    public function show(HandOver $handover)
    {
        $handover->load('items', 'stockItems');
        return view('warehouse.handovers.show', compact('handover'));
    }

    // Form edit handover
    public function edit(HandOver $handover)
    {
        return view('warehouse.handovers.edit', compact('handover'));
    }

    // Update handover
    public function update(Request $request, HandOver $handover)
    {
        $handover->update($request->all());
        // Logika update Handover Items jika diperlukan
        return redirect()->route('handovers.index')->with('success', 'Handover berhasil diupdate.');
    }

    // Hapus handover
    public function destroy(HandOver $handover)
    {
        $handover->delete(); // FK dengan cascade → items & handover_items otomatis terhapus
        return redirect()->route('handovers.index')->with('success', 'Handover berhasil dihapus.');
    }
}
