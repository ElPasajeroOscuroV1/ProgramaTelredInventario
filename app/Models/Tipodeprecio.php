<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class tipodeprecio extends Model
{
    use HasFactory;

    protected $fillable = [
        'preciodecompra',
        'precioventamayor',
        'preciotecnico',
        'psf',
        'ps',
        'precio_id',
    ];

    public function precio():BelongsTo
    {
        return $this->belongsTo(Precio::class, 'precio_id');
    }
}
