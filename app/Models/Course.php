<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'credits',
        'department',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'credits' => 'integer'
    ];

    public function offerings(): HasMany
    {
        return $this->hasMany(Offering::class);
    }

    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(Teacher::class, 'offerings');
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'offerings');
    }
}
