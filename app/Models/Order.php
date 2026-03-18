<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    public const STATUS_EN_GESTION = 'en gestión';
    public const STATUS_DESPACHADO = 'despachado';
    public const STATUS_ENTREGADO = 'entregado';

    protected $fillable = [
        'quote_id',
        'provider_id',
        'total',
        'status',
    ];

    protected $casts = [
        'total' => 'decimal:2',
    ];

    public function quote(): BelongsTo
    {
        return $this->belongsTo(Quote::class);
    }

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }
}
