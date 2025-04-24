<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = ['course_id', 'title', 'content', 'order'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_lessons')
                    ->withPivot('completed', 'completed_at')
                    ->withTimestamps();
    }
}