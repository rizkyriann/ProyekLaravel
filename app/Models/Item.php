<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Handover;
use App\Models\HandOverItem;
use App\Models\InvoiceItem;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku',
        'name',
        'handover_id',
        'handover_item_id',
        'quantity',
        'price',
        'status'
    ];

    public function handover()
    {
        return $this->belongsTo(Handover::class);
    }

    public function handoverItem()
    {
        return $this->belongsTo(HandOverItem::class, 'handover_item_id');
    }

    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class, 'item_id');
    }
}
