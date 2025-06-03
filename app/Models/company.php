<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class company extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'logo',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
