<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InvoiceController extends Controller
{

    
    /**
     * List invoice
     */
    public function index()
    {
        $invoices = Invoice::latest()->get();
        return view('pages.invoices.index', compact('invoices'));
    }

    /**
     * Form buat invoice
     */
    public function create()
    {
        // hanya item dengan stok tersedia
        $items = Item::where('quantity', '>', 0)->get();

        return view('pages.invoices.create', [
            'items' => $items,
            'invoiceNo' => $this->generateInvoiceNo()
        ]);
    }

    /**
     * Simpan invoice (STOCK OUT)
     */
    public function store(Request $request)
    {
        // ======================
        // VALIDASI REQUEST
        // ======================
        $request->validate([
            'date'              => 'required|date',
            'customer'          => 'required|string',
            'items'             => 'required|array|min:1',
            'items.*.item_id'   => 'required|exists:items,id',
            'items.*.price'     => 'required|numeric|min:0',
            'items.*.quantity'  => 'required|integer|min:1',
        ]);

        try {
            DB::transaction(function () use ($request) {

                // ======================
                // VALIDASI STOK (LOCK)
                // ======================
                foreach ($request->items as $row) {
                    $item = Item::lockForUpdate()->findOrFail($row['item_id']);

                    if ($item->quantity < $row['quantity']) {
                        throw new \Exception(
                            "Stok {$item->name} tidak mencukupi"
                        );
                    }
                }

                // ======================
                // SIMPAN INVOICE
                // ======================
                $invoice = Invoice::create([
                    'invoice_no'    => $this->generateInvoiceNo(),
                    'date'          => $request->date,
                    'customer'      => $request->customer,
                    'total'         => $request->total,
                    'status'        => 'draft',
                ]);

                // ======================
                // SIMPAN ITEM + KURANGI STOK
                // ======================
                foreach ($request->items as $row) {
                    $item = Item::lockForUpdate()->findOrFail($row['item_id']);

                    InvoiceItem::create([
                        'invoice_id'    => $invoice->id,
                        'item_id'       => $item->id,
                        'quantity'      => $row['quantity'],
                        'price'         => $item->price, // harga dari DB
                        'subtotal'      => $row['quantity'] * $item->price,
                    ]);

                }
            });

            return redirect()
                ->route('warehouse.invoices.index')
                ->with('success', 'Invoice berhasil dibuat');

        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Konfirmasi & Paid Invoice (STOCK OUT)
     */
    public function markAsPaid(Invoice $invoice)
    {
        if ($invoice->status !== 'draft') {
            return back()->with('error', 'Invoice sudah diproses.');
        }

        try {
            DB::transaction(function () use ($invoice) {

                foreach ($invoice->items as $row) {
                    $item = Item::lockForUpdate()->findOrFail($row->item_id);

                    if ($item->quantity < $row->quantity) {
                        throw new \Exception(
                            "Stok {$item->name} tidak mencukupi"
                        );
                    }

                    // kurangi stok
                    $item->decrement('quantity', $row->quantity);
                }

                $invoice->update([
                    'status' => 'paid',
                    'paid_at' => now(),
                ]);
            });

            return back()->with('success', 'Invoice berhasil dikonfirmasi & dibayar');

        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }


    /**
     * Detail invoice
     */
    public function show(Invoice $invoice)
    {
        $invoice->load('items.item');
        return view('pages.invoices.show', compact('invoice'));
    }

    /**
     * Cancel invoice (ROLLBACK STOK)
     */
    public function cancel(Invoice $invoice)
    {
        if ($invoice->status === 'cancelled') {
            return back()->with('error', 'Invoice sudah dibatalkan');
        }

        try {
            DB::transaction(function () use ($invoice) {
                foreach ($invoice->items as $row) {
                    $row->item->increment('quantity', $row->quantity);
                }

                $invoice->update([
                    'status' => 'cancelled'
                ]);
            });

            return back()->with('success', 'Invoice dibatalkan dan stok dikembalikan');

        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    private function generateInvoiceNo()
    {
        $date = Carbon::now()->format('Ym');

        $last = Invoice::where('invoice_no', 'like', "INVOICE-$date%")
            ->latest('id')
            ->first();

        $number = $last
            ? intval(substr($last->invoice_no, -4)) + 1
            : 1;

        return "INVOICE-$date-" . str_pad($number, 4, '0', STR_PAD_LEFT);
    }


    /**
     * Soft delete invoice (TANPA rollback stok)
     */
    public function destroy(Invoice $invoice)
    {
        if ($invoice->status === 'paid') {
            return back()->with('error', 'Invoice sudah dibayar, tidak bisa dihapus');
        }

        $invoice->delete();

        return redirect()
            ->route('warehouse.invoices.index')
            ->with('success', 'Invoice berhasil disembunyikan');
    }
}
