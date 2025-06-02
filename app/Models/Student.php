<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    protected $fillable = [
        "student_id",
        "first_name",
        "last_name",
        "email",
        "phone",
        "date_of_birth",
        "address",
        "is_active"
    ];

    protected $casts = [
        "is_active" => "boolean",
        "date_of_birth" => "date"
    ];

    public function offerings(): HasMany
    {
        return $this->hasMany(Offering::class);
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
}