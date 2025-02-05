<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Version extends Model
{
    protected $fillable = [
        'identifier',
        'description',
        'notes'
    ];

    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    public function topicBlocks()
    {
        return $this->hasManyThrough(TopicBlock::class, Topic::class);
    }
}
