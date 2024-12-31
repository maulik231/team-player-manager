<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Team extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'state', 'country'];

    /* ************************ RELATIONS ************************ */
    /**
     * @return BelongsToMany
     */
    public function players()
    {
        return $this->belongsToMany(Player::class, 'team_player')
            ->withPivot('sort_order')
            ->orderBy('team_player.sort_order');
    }
}
