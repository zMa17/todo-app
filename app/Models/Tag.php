<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['nama', 'warna'];

    public function todos()
    {
        return $this->belongsToMany(Todo::class, 'todo_tags');
    }
}
