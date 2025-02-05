<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = [
        'version_id',
        'name',
        'slug'
    ];

    public function blocks()
    {
        return $this->hasMany(TopicBlock::class)->orderBy('order', 'asc');
    }
    
    public function versioning()
    {
        return $this->belongsTo(Version::class, 'version_id');
    }

    public function scopeVersion($query, $version)
    {
        return $query->where('version_id', $version->id);
    }
}

