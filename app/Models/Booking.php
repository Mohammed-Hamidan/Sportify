<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'field_id',
        'player_id',
        'team_id',
        'date',
        'start_time',
        'end_time',
        'total_price',
        'payment_method',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
        'total_price' => 'decimal:2',
    ];

    public function field(): BelongsTo
    {
        return $this->belongsTo(Field::class);
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(User::class, 'player_id');
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}

