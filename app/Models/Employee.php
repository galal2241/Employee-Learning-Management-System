<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Employee extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'password'];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'employee_courses')
                    ->withPivot('progress', 'completed')
                    ->withTimestamps();
    }

    public function lessons()
    {
        return $this->belongsToMany(Lesson::class, 'employee_lessons')
                    ->withPivot('completed', 'completed_at')
                    ->withTimestamps();
    }

    public function quizzes()
    {
        return $this->belongsToMany(Quiz::class, 'employee_quizzes')
                    ->withPivot('answers', 'score', 'passed', 'submitted_at')
                    ->withTimestamps();
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}