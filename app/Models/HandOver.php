<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\HandOverItem;
use App\Models\Item;

class Handover extends Model
{
    use HasFactory;

    protected $fillable = [
        'handover_no',
        'source',
        'handover_date',
        'total_items',
        'status',
        'notes'
    ];

    // Relasi → HandOver memiliki banyak handover_items
    public function handoverItems()
    {
        return $this->hasMany(HandoverItem::class, 'handover_id');
    }

    // Relasi → HandOver memiliki banyak Items di stok gudang
    public function stockItems()
    {
        return $this->hasMany(Item::class, 'handover_id');
    }
}
