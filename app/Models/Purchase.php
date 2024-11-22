<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchases extends Model
{
    use HasFactory;

    public $timestamps = false;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id',
        'listing_id',
        'purchase_date',
    ];

    /**
     * Get the customer that owns the purchase.
     */
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * Get the listing that the purchase is associated with.
     */
    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }
}
