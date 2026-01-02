<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HandoverItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'handover_id',
        'sku',
        'item_name',
        'quantity',
        'price',
        'notes'
    ];

    public function handover()
    {
        return $this->belongsTo(HandOver::class);
    }

    public function item()
    {
        return $this->hasOne(Item::class, 'sku', 'sku'); 
        // menghubungkan ke items berdasarkan SKU unik
    }
}
