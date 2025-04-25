<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\Employee;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $employee = Employee::first();

        $courses = $employee ? $employee->courses()->get() : collect([]);

        $lessons = $employee ? $employee->lessons()->with('course')->get() : collect([]);

        $quizzes = $employee ? $employee->quizzes()->with('course')->get() : collect([]);

        $certificates = $employee ? $employee->courses()->wherePivot('completed', true)->get()->map(function ($course) use ($employee) {
            return (object) [
                'course' => $course,
                'employee_id' => $employee->id,
                'course_id' => $course->id,
                'issued_date' => $course->pivot->updated_at,
            ];
        }) : collect([]);

        return view('dashboard', compact('courses', 'lessons', 'quizzes', 'certificates'));
    }
}