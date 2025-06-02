<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    protected $fillable = [
        "code",
        "name",
        "description",
        "department",
        "credits",
        "is_active"
    ];

    protected $casts = [
        "is_active" => "boolean",
        "credits" => "integer"
    ];

    public function offerings(): HasMany
    {
        return $this->hasMany(Offering::class);
    }
}