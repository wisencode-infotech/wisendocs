<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlockAttribute extends Model
{
    use HasFactory;

    protected $fillable = ['block_type', 'attributes'];

    protected $casts = [
        'attributes' => 'array', // Auto-casts JSON to array
    ];

    public function blockType()
    {
        return $this->belongsTo(BlockType::class, 'block_type');
    }

    
}
