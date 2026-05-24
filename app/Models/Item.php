<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes;

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
        return $this->belongsTo(HandoverItem::class, 'handover_item_id');
    }

    public function handoverItems()
    {
        return $this->hasMany(HandoverItem::class, 'handover_id', 'handover_id');
    }

    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class, 'item_id');
    }
}
