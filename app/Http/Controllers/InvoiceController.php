<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    // List invoice
    public function index()
    {
        $invoices = Invoice::latest()->get();
        return view('warehouse.invoices.index', compact('invoices'));
    }

    // Form buat invoice
    public function create()
    {
        // hanya tampilkan item dengan stok > 0
        $items = Item::where('quantity', '>', 0)->get();
        return view('warehouse.invoices.create', compact('items'));
    }

    // Simpan invoice (STOCK OUT)
    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {

            // 1. VALIDASI STOK (SEMUA ITEM)
            foreach ($request->items as $row) {
                $item = Item::lockForUpdate()->findOrFail($row['item_id']);

                if ($item->quantity < $row['quantity']) {
                    throw new \Exception(
                        "Stok {$item->name} tidak mencukupi"
                    );
                }
            }

            // 2. SIMPAN INVOICE
            $invoice = Invoice::create([
                'invoice_no' => $request->invoice_no,
                'invoice_date' => $request->invoice_date,
                'customer_name' => $request->customer_name,
                'status' => 'paid'
            ]);

            // 3. SIMPAN INVOICE ITEMS + KURANGI STOK
            foreach ($request->items as $row) {
                $item = Item::lockForUpdate()->findOrFail($row['item_id']);

                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'item_id' => $item->id,
                    'quantity' => $row['quantity'],
                    'price' => $row['price'],
                    'subtotal' => $row['quantity'] * $row['price'],
                ]);

                // 4. KURANGI STOK
                $item->decrement('quantity', $row['quantity']);
            }
        });

        return redirect()
            ->route('invoices.index')
            ->with('success', 'Invoice berhasil dibuat');
    }

    // Detail invoice
    public function show(Invoice $invoice)
    {
        $invoice->load('items.item');
        return view('warehouse.invoices.show', compact('invoice'));
    }

    // Hapus invoice (opsional, biasanya soft delete)
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()
            ->route('invoices.index')
            ->with('success', 'Invoice dihapus');
    }
}
