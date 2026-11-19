<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TeacherDocument extends Model
{
    protected $fillable = [
        'teacher_id',
        'document_type_id',
        'assessment_period_id',
        'title',
        'file_path',
        'original_name',
        'mime_type',
        'file_size',
        'status',
        'notes',
    ];

    /**
     * Guru pemilik dokumen.
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(
            Teacher::class,
            'teacher_id'
        );
    }

    /**
     * Jenis dokumen.
     */
    public function documentType(): BelongsTo
    {
        return $this->belongsTo(
            DocumentType::class,
            'document_type_id'
        );
    }

    /**
     * Periode semester dokumen.
     */
    public function assessmentPeriod(): BelongsTo
    {
        return $this->belongsTo(
            AssessmentPeriod::class,
            'assessment_period_id'
        );
    }

    /**
     * Riwayat verifikasi dokumen.
     */
    public function verifications(): HasMany
    {
        return $this->hasMany(
            DocumentVerification::class,
            'teacher_document_id'
        );
    }

    /**
     * Verifikasi terbaru.
     */
    public function verification(): HasOne
    {
        return $this->hasOne(
            DocumentVerification::class,
            'teacher_document_id'
        )->latestOfMany();
    }
}
