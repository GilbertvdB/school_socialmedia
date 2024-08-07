<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Model
{
    use HasFactory;

    protected $table = 'post_images';
    
    protected $fillable = [
        'post_id',
        'url',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
