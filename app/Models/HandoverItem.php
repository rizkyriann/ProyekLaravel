<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HandoverItem extends Model
{
    use HasFactory;

    protected $table = 'handover_items';

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
        return $this->belongsTo(Handover::class);
    }

    public function item()
    {
        return $this->hasOne(Item::class, 'handover_item_id');
    }
}
