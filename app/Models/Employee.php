<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'password'];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'employee_courses')
                    ->withPivot('progress', 'completed')
                    ->withTimestamps();
    }
}
