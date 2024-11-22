<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'item_id',
        'seller_id',
        'price',
    ];

    /**
     * Get the item that the listing is for.
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * Get the user that is selling the item.
     */
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
}
