<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{

    protected $fillable = [
        'name',
        'pass_mark',
    ];

    protected $casts = [
        'pass_mark' => 'integer',
    ];

    // Relationship with users (students)
    public function students()
    {
        return $this->belongsToMany(User::class, 'student_subjects')
                    ->withPivot('mark')
                    ->withTimestamps();
    }
}
