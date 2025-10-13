<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InterventionImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'intervention_id',
        'filename',
        'original_name',
        'path',
        'size',
        'mime_type',
    ];

    /**
     * Relation avec l'intervention
     */
    public function intervention()
    {
        return $this->belongsTo(Intervention::class);
    }

    /**
     * Retourne l'URL complète de l'image
     */
    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->path);
    }

    /**
     * Retourne l'URL du thumbnail
     */
    public function getThumbnailUrlAttribute(): string
    {
        $pathInfo = pathinfo($this->path);
        $thumbnailPath = $pathInfo['dirname'] . '/thumbnails/' . $pathInfo['filename'] . '_thumb.' . $pathInfo['extension'];
        return asset('storage/' . $thumbnailPath);
    }
}
