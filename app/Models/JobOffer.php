<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobOffer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'company',
        'location',
        'city',
        'region',
        'domain',
        'salary_min',
        'salary_max',
        'employment_type',
        'required_experience',
        'education_level',
        'work_mode',
        'required_skills',
        'benefits',
        'posted_at',
        'deadline',
        'is_active',
    ];

    protected $casts = [
        'required_skills' => 'array',
        'benefits' => 'array',
        'posted_at' => 'datetime',
        'deadline' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }
}
