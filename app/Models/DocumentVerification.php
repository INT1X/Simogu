<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentVerification extends Model
{
    protected $fillable = [
        'teacher_document_id',
        'supervisor_id',
        'status',
        'score',
        'notes',
        'verified_at',
    ];

    protected $casts = [
        'score' => 'decimal:2',
        'verified_at' => 'datetime',
    ];

    public function document(): BelongsTo
    {
        return $this->belongsTo(
            TeacherDocument::class,
            'teacher_document_id'
        );
    }

    public function supervisor(): BelongsTo
    {
        return $this->belongsTo(
            Supervisor::class,
            'supervisor_id'
        );
    }
}