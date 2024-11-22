<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Navigation extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'Navigation';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'game_id',
        'name',
        'parent_id',
    ];

    /**
     * Get the game that owns the navigation.
     */
    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}
