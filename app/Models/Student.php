<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasUuids, HasFactory;

    /**
     * Add a unique UUID to a student.
     */
    public function uniqueIds(): array
    {
        return ['uuid'];
    }
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'birthdate',
        'gender',
    ];

    public function classroom(): BelongsToMany
    {
        return $this->belongsToMany(Classroom::class, 'classroom_student', 'student_id', 'classroom_id')
        ->withTimestamps();
    }

    public function parents(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'parent_student', 'student_id', 'user_id')
        ->withTimestamps();
    }

    // Accessor to get post group names as a comma-separated string
    public function getPostGroupsNamesAttribute()
    {
        return $this->postGroups->pluck('name')->implode(', ');
    }

    // Accessor to get post group names as a comma-separated string
    public function getClassroomNameAttribute()
    {
        return $this->classroom()->pluck('name')->implode(', ');
    }
}
