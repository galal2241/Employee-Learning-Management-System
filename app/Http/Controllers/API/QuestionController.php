<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{
    /**
     * Display a listing of the questions for a specific quiz.
     *
     * @param  int  $courseId
     * @param  int  $quizId
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($courseId, $quizId)
    {
        $course = Course::find($courseId);
        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }

        $quiz = Quiz::where('course_id', $courseId)->find($quizId);
        if (!$quiz) {
            return response()->json(['message' => 'Quiz not found'], 404);
        }

        $questions = Question::where('quiz_id', $quizId)->get();

        return response()->json([
            'message' => 'Questions retrieved successfully',
            'data' => $questions
        ], 200);
    }

    /**
     * Store a newly created question in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $courseId
     * @param  int  $quizId
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $courseId, $quizId)
    {
        $course = Course::find($courseId);
        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }

        $quiz = Quiz::where('course_id', $courseId)->find($quizId);
        if (!$quiz) {
            return response()->json(['message' => 'Quiz not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'question_text' => 'required|string',
            'options' => 'required|array|min:2',
            'correct_answer' => 'required|string|in:'.implode(',', $request->options),
            'marks' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $question = Question::create([
            'quiz_id' => $quizId,
            'question_text' => $request->question_text,
            'options' => $request->options,
            'correct_answer' => $request->correct_answer,
            'marks' => $request->marks,
        ]);

        return response()->json([
            'message' => 'Question created successfully',
            'data' => $question
        ], 201);
    }

    /**
     * Display the specified question.
     *
     * @param  int  $courseId
     * @param  int  $quizId
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($courseId, $quizId, $id)
    {
        $course = Course::find($courseId);
        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }

        $quiz = Quiz::where('course_id', $courseId)->find($quizId);
        if (!$quiz) {
            return response()->json(['message' => 'Quiz not found'], 404);
        }

        $question = Question::where('quiz_id', $quizId)->find($id);
        if (!$question) {
            return response()->json(['message' => 'Question not found'], 404);
        }

        return response()->json([
            'message' => 'Question retrieved successfully',
            'data' => $question
        ], 200);
    }

    /**
     * Update the specified question in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $courseId
     * @param  int  $quizId
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $courseId, $quizId, $id)
    {
        $course = Course::find($courseId);
        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }

        $quiz = Quiz::where('course_id', $courseId)->find($quizId);
        if (!$quiz) {
            return response()->json(['message' => 'Quiz not found'], 404);
        }

        $question = Question::where('quiz_id', $quizId)->find($id);
        if (!$question) {
            return response()->json(['message' => 'Question not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'question_text' => 'required|string',
            'options' => 'required|array|min:2',
            'correct_answer' => 'required|string|in:'.implode(',', $request->options),
            'marks' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $question->update([
            'question_text' => $request->question_text,
            'options' => $request->options,
            'correct_answer' => $request->correct_answer,
            'marks' => $request->marks,
        ]);

        return response()->json([
            'message' => 'Question updated successfully',
            'data' => $question
        ], 200);
    }

    /**
     * Remove the specified question from storage.
     *
     * @param  int  $courseId
     * @param  int  $quizId
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($courseId, $quizId, $id)
    {
        $course = Course::find($courseId);
        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }

        $quiz = Quiz::where('course_id', $courseId)->find($quizId);
        if (!$quiz) {
            return response()->json(['message' => 'Quiz not found'], 404);
        }

        $question = Question::where('quiz_id', $quizId)->find($id);
        if (!$question) {
            return response()->json(['message' => 'Question not found'], 404);
        }

        $question->delete();

        return response()->json([
            'message' => 'Question deleted successfully'
        ], 200);
    }
}
