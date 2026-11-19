<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Model
{
    protected $fillable = [
        'user_id',
        'school_id',
        'photo',
        'name',
        'nip',
        'nik',
        'gender',
        'subject',
        'phone',
        'email',
        'employment_status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    /**
     * Riwayat penilaian kinerja guru
     */
    public function performanceAssessments(): HasMany
    {
        return $this->hasMany(
            PerformanceAssessment::class
        );
    }

    /**
     * Dokumen yang diunggah oleh guru
     */
    public function teacherDocuments(): HasMany
    {
        return $this->hasMany(
            TeacherDocument::class,
            'teacher_id'
        );
    }
}