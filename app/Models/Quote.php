<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Quote extends Model
{
    use HasFactory;

    public const STATUS_PENDIENTE = 'pendiente';
    public const STATUS_COTIZADO = 'cotizado';
    public const STATUS_APROBADO = 'aprobado';
    public const STATUS_RECHAZADO = 'rechazado';

    protected $fillable = [
        'user_id',
        'location',
        'project_type',
        'message',
        'status',
        'total_estimated',
    ];

    protected $casts = [
        'total_estimated' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(QuoteItem::class);
    }

    public function order(): HasOne
    {
        return $this->hasOne(Order::class);
    }
}
