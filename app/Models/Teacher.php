<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'department',
        'title',
        'bio',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function offerings(): HasMany
    {
        return $this->hasMany(Offering::class);
    }

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'offerings');
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'offerings');
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
