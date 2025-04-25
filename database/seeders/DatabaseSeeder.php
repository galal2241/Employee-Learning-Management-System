<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Employee;
use App\Models\Lesson;
use App\Models\Quiz;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $employee = Employee::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test Employee',
                'password' => bcrypt('password'),
            ]
        );

        $course = Course::firstOrCreate(
            ['title' => 'Laravel Basics'],
            ['description' => 'Learn the fundamentals of Laravel.']
        );

        $lesson = Lesson::firstOrCreate(
            [
                'course_id' => $course->id,
                'title' => 'Introduction to Laravel',
            ],
            [
                'content' => 'This is the first lesson.',
                'order' => 1,
            ]
        );

        $quiz = Quiz::firstOrCreate(
            [
                'course_id' => $course->id,
                'title' => 'Laravel Quiz',
            ],
            ['total_marks' => 100]
        );

        if (!$employee->courses()->where('course_id', $course->id)->exists()) {
            $employee->courses()->attach($course->id, [
                'progress' => 100,
                'completed' => true,
            ]);
        }

        if (!$employee->lessons()->where('lesson_id', $lesson->id)->exists()) {
            $employee->lessons()->attach($lesson->id, [
                'completed' => true,
                'completed_at' => now(),
            ]);
        }

        if (!$employee->quizzes()->where('quiz_id', $quiz->id)->exists()) {
            $employee->quizzes()->attach($quiz->id, [
                'answers' => json_encode(['q1' => 'a']),
                'score' => 80,
                'passed' => true,
                'submitted_at' => now(),
            ]);
        }
    }
}