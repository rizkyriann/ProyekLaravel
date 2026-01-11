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

    public function getStatusBadgeClassAttribute()
    {
        return match ($this->status) {
            'draft' => 'bg-yellow-50 text-yellow-700 dark:bg-yellow-500/15 dark:text-yellow-400',
            'confirmed' => 'bg-green-50 text-green-700 dark:bg-green-500/15 dark:text-green-500',
            'cancelled' => 'bg-red-50 text-red-700 dark:bg-red-500/15 dark:text-red-500',
            default => 'bg-gray-100 text-gray-700 dark:bg-gray-500/15 dark:text-gray-400',
        };
    }


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
