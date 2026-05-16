<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Todo;

class Kategori extends Model
{
    protected $fillable = ['nama', 'warna'];

    public function todos()
    {
        return $this->hasMany(Todo::class);
    }
}
