<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriTindakan extends Model
{
    use HasFactory;
    public function jenisTindakan()
    {
        return $this->hasMany(JenisTindakan::class);
    }
}