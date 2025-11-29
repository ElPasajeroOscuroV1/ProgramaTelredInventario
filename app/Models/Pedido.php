<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class pedido extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'fecha',
        'tipodepedido',
        'cliente_id',

    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(cliente::class, 'cliente_id');
    }
    
    public function precio(): HasMany
    {
        return $this->hasMany(precio::class, 'precio_id');
    }
}
