<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlockType extends Model
{
    use HasFactory;

    protected $fillable = ['title'];

    public function topicBlocks()
    {
        return $this->hasMany(TopicBlock::class, 'block_type_id');
    }
}
