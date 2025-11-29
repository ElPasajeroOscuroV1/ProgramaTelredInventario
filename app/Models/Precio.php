<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use PhpParser\Node\Expr\FuncCall;

class precio extends Model
{
    use HasFactory;

    protected $fillable = [
        'producto_id',
        'pedido_id',
    ];

    public function producto():BelongsTo
    {
        return $this->belongsTo(producto::class, 'producto_id');
    }
    public function pedido ():BelongsTo
    {
        return $this->belongsTo(pedido::class, 'pedido_id');
    }
    public function tipodeprecio():HasMany
    {
        return $this->hasMany(Tipodeprecio::class);
    }
}
