<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sport extends Model
{
    use HasFactory;

    protected $fillable = [
        'sport_name',
    ];

    public function fields(): HasMany
    {
        return $this->hasMany(Field::class);
    }

    public function teams(): HasMany
    {
        return $this->hasMany(Team::class);
    }
}

