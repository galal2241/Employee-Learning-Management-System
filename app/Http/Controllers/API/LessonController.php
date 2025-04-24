<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LessonController extends Controller
{
    /**
     * Display a listing of the lessons for a specific course.
     *
     * @param  int  $courseId
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($courseId)
    {
        $course = Course::find($courseId);

        if (!$course) {
            return response()->json([
                'message' => 'Course not found'
            ], 404);
        }

        $lessons = Lesson::where('course_id', $courseId)->orderBy('order')->get();

        return response()->json([
            'message' => 'Lessons retrieved successfully',
            'data' => $lessons
        ], 200);
    }

    /**
     * Store a newly created lesson in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $courseId
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $courseId)
    {
        $course = Course::find($courseId);

        if (!$course) {
            return response()->json([
                'message' => 'Course not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'order' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $lesson = Lesson::create([
            'course_id' => $courseId,
            'title' => $request->title,
            'content' => $request->content,
            'order' => $request->order,
        ]);

        return response()->json([
            'message' => 'Lesson created successfully',
            'data' => $lesson
        ], 201);
    }

    /**
     * Display the specified lesson.
     *
     * @param  int  $courseId
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($courseId, $id)
    {
        $lesson = Lesson::where('course_id', $courseId)->find($id);

        if (!$lesson) {
            return response()->json([
                'message' => 'Lesson not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Lesson retrieved successfully',
            'data' => $lesson
        ], 200);
    }

    /**
     * Update the specified lesson in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $courseId
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $courseId, $id)
    {
        $lesson = Lesson::where('course_id', $courseId)->find($id);

        if (!$lesson) {
            return response()->json([
                'message' => 'Lesson not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'order' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $lesson->update([
            'title' => $request->title,
            'content' => $request->content,
            'order' => $request->order,
        ]);

        return response()->json([
            'message' => 'Lesson updated successfully',
            'data' => $lesson
        ], 200);
    }

    /**
     * Remove the specified lesson from storage.
     *
     * @param  int  $courseId
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($courseId, $id)
    {
        $lesson = Lesson::where('course_id', $courseId)->find($id);

        if (!$lesson) {
            return response()->json([
                'message' => 'Lesson not found'
            ], 404);
        }

        $lesson->delete();

        return response()->json([
            'message' => 'Lesson deleted successfully'
        ], 200);
    }
}