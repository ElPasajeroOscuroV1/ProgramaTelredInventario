<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    use HasFactory;

    protected $table = 'cotizaciones';

    protected $fillable = [
        'cliente_id', 'user_id', 'fecha', 'estado',
        'total_con_descuento',
        'porcentaje_descuento',

    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class)
            ->withPivot('cantidad', 'precio_unitario');
    }

    // Accesor para usar el total final fácilmente
    public function getTotalFinalAttribute()
    {
        return $this->total_con_descuento ?? $this->total;
    }
}
