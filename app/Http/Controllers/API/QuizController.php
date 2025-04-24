<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuizController extends Controller
{
    /**
     * Display a listing of the quizzes for a specific course.
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

        $quizzes = Quiz::where('course_id', $courseId)->get();

        return response()->json([
            'message' => 'Quizzes retrieved successfully',
            'data' => $quizzes
        ], 200);
    }

    /**
     * Store a newly created quiz in storage.
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
            'total_marks' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $quiz = Quiz::create([
            'course_id' => $courseId,
            'title' => $request->title,
            'total_marks' => $request->total_marks,
        ]);

        return response()->json([
            'message' => 'Quiz created successfully',
            'data' => $quiz
        ], 201);
    }

    /**
     * Display the specified quiz.
     *
     * @param  int  $courseId
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($courseId, $id)
    {
        $quiz = Quiz::where('course_id', $courseId)->find($id);

        if (!$quiz) {
            return response()->json([
                'message' => 'Quiz not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Quiz retrieved successfully',
            'data' => $quiz
        ], 200);
    }

    /**
     * Update the specified quiz in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $courseId
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $courseId, $id)
    {
        $quiz = Quiz::where('course_id', $courseId)->find($id);

        if (!$quiz) {
            return response()->json([
                'message' => 'Quiz not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'total_marks' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $quiz->update([
            'title' => $request->title,
            'total_marks' => $request->total_marks,
        ]);

        return response()->json([
            'message' => 'Quiz updated successfully',
            'data' => $quiz
        ], 200);
    }

    /**
     * Remove the specified quiz from storage.
     *
     * @param  int  $courseId
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($courseId, $id)
    {
        $quiz = Quiz::where('course_id', $courseId)->find($id);

        if (!$quiz) {
            return response()->json([
                'message' => 'Quiz not found'
            ], 404);
        }

        $quiz->delete();

        return response()->json([
            'message' => 'Quiz deleted successfully'
        ], 200);
    }
}