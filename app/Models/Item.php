<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku',
        'name',
        'handover_id',
        'quantity',
        'price',
        'status'
    ];

    public function handover()
    {
        return $this->belongsTo(HandOver::class);
    }

    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class, 'item_id');
    }
}
