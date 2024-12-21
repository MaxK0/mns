<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    protected $fillable = [
        'title',
    ];

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }
}
