<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'game_id',
        'name',
        'image_id',
    ];

    /**
     * Get the game that owns the item.
     */
    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    /**
     * Get the image associated with the item.
     */
    public function image()
    {
        return $this->belongsTo(Image::class);
    }
}
