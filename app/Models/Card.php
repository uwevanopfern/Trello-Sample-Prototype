<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use DateTimeInterface;

class Card extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'deleted_at',
        'draggable_order'
    ];

    public function column(): BelongsTo
    {
        return $this->belongsTo(Column::class);
    }
}
