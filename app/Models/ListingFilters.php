<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListingFilters extends Model
{
    use HasFactory;

    protected $table = "listing_filters";
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'listing_id',
        'filter_id',
    ];

    /**
     * Get the listing that the filter is associated with.
     */
    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }

    /**
     * Get the filter that the listing is associated with.
     */
    public function filter()
    {
        return $this->belongsTo(Filter::class);
    }
}
