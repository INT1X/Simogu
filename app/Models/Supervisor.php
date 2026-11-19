<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supervisor extends Model
{
    protected $fillable = [
        'school_id',
        'user_id', // <-- Tambahkan ini jika ada kolom user_id
        'nip',
        'name',
        'photo',
        'phone',
        'email',
        'status',
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    /**
     * Relasi ke Model User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Riwayat penilaian yang dilakukan pengawas
     */
    public function performanceAssessments(): HasMany
    {
        return $this->hasMany(
            PerformanceAssessment::class
        );
    }
}