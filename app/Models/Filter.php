<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'filter_category_id',
        'filter_name',
    ];

    /**
     * Get the filter category that owns the filter.
     */
    public function filterCategory()
    {
        return $this->belongsTo(FilterCategories::class);
    }
}
