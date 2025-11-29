<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class marca extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
    ];

    public function producto(): HasMany
    {
        return $this->hasMany(producto::class);
    }
}
