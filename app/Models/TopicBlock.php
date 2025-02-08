<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class TopicBlock extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'topic_id',
        'block_type_id',
        'attributes',
        'order',
        'start_content_level',
        'parent_id'
    ];

    public function blockType()
    {
        return $this->belongsTo(BlockType::class, 'block_type_id');
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class, 'topic_id');
    }

    // Recursive relationship for parent
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    // Recursive relationship for children
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('order');
    }
}
