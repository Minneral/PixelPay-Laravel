<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilterCategories extends Model
{
    use HasFactory;

    protected $table = "filter_categories";
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'game_id',
        'category',
    ];

    /**
     * Get the game that owns the filter category.
     */
    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    /**
     * Get the filters for the filter category.
     */
    public function filters()
    {
        return $this->hasMany(Filter::class);
    }
}
