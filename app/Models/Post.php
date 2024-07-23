<?php

namespace App\Models;

use App\Events\PostCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'body',
        'author_id',
        'published_at',
    ];

    protected $dispatchesEvents = [
        'created' => PostCreated::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function postGroups(): BelongsToMany
    {
        return $this->belongsToMany(PostGroup::class)->withTimestamps();
    }

    // Accessor to get post group names as a comma-separated string
    public function getPostGroupsNamesAttribute()
    {
        return $this->postGroups->pluck('name')->implode(', ');
    }
}
