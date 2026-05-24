<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Daftar stok barang gudang
     * - Search SKU / nama barang
     * - Pagination
     */
    public function index(Request $request)
    {
        $query = Item::with(['handoverItem', 'handover'])
            ->where('status', 'active');

        // Search
        $query->when($request->filled('q'), function ($q) use ($request) {
            $search = $request->q;

            $q->where(function ($qq) use ($search) {
                $qq->where('sku', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%");
            });
        });

        // Pagination
        $items = $query
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('pages.warehouse.index', compact('items'));
    }

    /**
     * Detail barang gudang
     */
    public function show($id)
    {
        $item = Item::with([
            'handover',
            'handoverItem'
        ])->findOrFail($id);

        return view('pages.warehouse.show', compact('item'));
    }

    /**
     * Kartu stok (riwayat keluar masuk)
     * (keluar dari invoice)
     */
    public function stockCard($id)
    {
        $item = Item::with([
            'handoverItem.handover',
            'invoiceItems' => function ($query) {
                $query->whereHas('invoice', function ($invoiceQuery) {
                    $invoiceQuery->where('status', 'paid');
                })->with('invoice');
            }
        ])->findOrFail($id);

        return view('pages.warehouse.stock-card', compact('item'));
    }

    /**
     * Search AJAX (untuk Invoice)
     */
    public function search(Request $request)
    {
        $request->validate([
            'q' => 'required|min:2'
        ]);

        $items = Item::with('handoverItem')
            ->where('status', 'active')
            ->where('quantity', '>', 0)
            ->where(function ($q) use ($request) {
                $q->where('sku', 'like', "%{$request->q}%")
                  ->orWhereHas('handoverItem', function ($hq) use ($request) {
                      $hq->where('item_name', 'like', "%{$request->q}%");
                  });
            })
            ->limit(10)
            ->get();

        return response()->json($items);
    }
}
