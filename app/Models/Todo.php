<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $fillable = [
        'user_id',
        'kategori_id',
        'judul',
        'deskripsi',
        'tanggal_deadline',
        'prioritas',
        'is_completed'
    ];

    protected $casts = [
        'tanggal_deadline' => 'date',
        'is_completed'     => 'boolean',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'todo_tags');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
