<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'title_placeholder',
        'desc_placeholder'
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function agents()
    {
        return $this->belongsToMany(User::class);
    }
}
