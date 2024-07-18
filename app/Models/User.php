<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'role',
        'email',
        'password',
        'contact_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'author_id');
    }

    public function postGroups(): BelongsToMany
    {
        return $this->belongsToMany(PostGroup::class)->withTimestamps();
    }

    // Accessor to get post group names as a comma-separated string .ie $post->post_groups_names
    public function getPostGroupsNamesAttribute()
    {
        return $this->postGroups->pluck('name')->implode(', ');
    }

    // filter the query to only include users with the parent role. ie User::parents()->
    public function scopeParents(Builder $query): Builder
    {
        return $query->where('role', 'parent');
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'parent_student', 'user_id', 'student_id')
                ->withTimestamps();
    }

    public function contact(): HasOne
    {
        return $this->hasOne(Contact::class);
    }
}
