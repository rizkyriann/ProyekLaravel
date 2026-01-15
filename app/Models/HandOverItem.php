<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\HandOver;
use App\Models\Item;

class HandoverItem extends Model
{
    protected $table = 'handover_items';

    use HasFactory;

    protected $fillable = [
        'handover_id',
        'sku',
        'name',
        'quantity',
        'price',
        'notes'
    ];

    public function handover()
    {
        return $this->belongsTo(Handover::class);
    }

    public function item()
    {
        return $this->hasOne(Item::class, 'handover_item_id'); 
        // menghubungkan ke items berdasarkan SKU unik
    }
}
