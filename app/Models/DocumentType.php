<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DocumentType extends Model
{
    protected $fillable = [
        'name',
        'description',
        'max_score',
        'is_active',
        'is_required',
    ];

    protected $casts = [
        'max_score' => 'decimal:2',
        'is_active' => 'boolean',
        'is_required' => 'boolean',
    ];

    public function teacherDocuments(): HasMany
    {
        return $this->hasMany(
            TeacherDocument::class,
            'document_type_id'
        );
    }
}