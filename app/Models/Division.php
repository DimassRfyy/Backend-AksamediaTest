<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Division extends Model
{
    protected $fillable = [
        'name'
    ];

    public function employees():HasMany
    {
        return $this->hasMany(Employee::class);
    }
}
