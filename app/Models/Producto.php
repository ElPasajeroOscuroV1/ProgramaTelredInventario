<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class producto extends Model
{
    use HasFactory;

    protected $fillable =[
        'descripcion',
        'modelo',
        'cantidad',
        'marca_id',
    ];

    public function marca():BelongsTo
    {
        return $this->belongsTo(Marca::class);
    }

    public function precios():HasMany
    {
        return $this->hasMany(Precio::class);
    }

    public function cotizaciones()
    {
        return $this->belongsToMany(Cotizacion::class, 'cotizacion_producto')
                    ->withPivot('cantidad', 'precio_unitario')
                    ->withTimestamps();
    }


}
