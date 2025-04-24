<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Employee;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProgressController extends Controller
{
    /**
     * Mark a lesson as completed for an employee.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $courseId
     * @param  int  $lessonId
     * @return \Illuminate\Http\JsonResponse
     */
    public function completeLesson(Request $request, $courseId, $lessonId)
    {
        $employee = auth('api')->user();
        $course = Course::find($courseId);
        $lesson = Lesson::where('course_id', $courseId)->find($lessonId);

        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }

        if (!$lesson) {
            return response()->json(['message' => 'Lesson not found'], 404);
        }

        // Check if employee is enrolled in the course
        $enrollment = $employee->courses()->where('course_id', $courseId)->first();
        if (!$enrollment) {
            return response()->json(['message' => 'Employee not enrolled in this course'], 403);
        }

        // Mark lesson as completed
        $employee->lessons()->syncWithoutDetaching([
            $lessonId => ['completed' => true, 'completed_at' => now()]
        ]);

        // Update course progress
        $this->updateCourseProgress($employee, $course);

        return response()->json([
            'message' => 'Lesson marked as completed',
            'lesson' => $lesson
        ], 200);
    }

    /**
     * Get the progress of an employee in a specific course.
     *
     * @param  int  $courseId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProgress($courseId)
    {
        $employee = auth('api')->user();
        $course = Course::find($courseId);

        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }

        $enrollment = $employee->courses()->where('course_id', $courseId)->first();
        if (!$enrollment) {
            return response()->json(['message' => 'Employee not enrolled in this course'], 403);
        }

        return response()->json([
            'message' => 'Progress retrieved successfully',
            'course' => $course,
            'progress' => $enrollment->pivot->progress,
            'completed' => $enrollment->pivot->completed
        ], 200);
    }

    /**
     * Update the progress of an employee in a course based on completed lessons.
     *
     * @param  \App\Models\Employee  $employee
     * @param  \App\Models\Course  $course
     * @return void
     */
    protected function updateCourseProgress(Employee $employee, Course $course)
    {
        $totalLessons = $course->lessons()->count();
        if ($totalLessons === 0) {
            return;
        }

        $completedLessons = $employee->lessons()
            ->whereIn('lesson_id', $course->lessons()->pluck('id'))
            ->wherePivot('completed', true)
            ->count();

        $progress = ($completedLessons / $totalLessons) * 100;

        $employee->courses()->updateExistingPivot($course->id, [
            'progress' => $progress,
            'completed' => $progress >= 100
        ]);
    }
}