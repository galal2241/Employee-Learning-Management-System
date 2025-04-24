<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuizSystemController extends Controller
{
    /**
     * Submit answers for a quiz and calculate the score.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $courseId
     * @param  int  $quizId
     * @return \Illuminate\Http\JsonResponse
     */
    public function submitQuiz(Request $request, $courseId, $quizId)
    {
        $employee = auth('api')->user();
        $course = Course::find($courseId);
        $quiz = Quiz::where('course_id', $courseId)->find($quizId);

        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }

        if (!$quiz) {
            return response()->json(['message' => 'Quiz not found'], 404);
        }

        // Check if employee is enrolled in the course
        $enrollment = $employee->courses()->where('course_id', $courseId)->first();
        if (!$enrollment) {
            return response()->json(['message' => 'Employee not enrolled in this course'], 403);
        }

        $validator = Validator::make($request->all(), [
            'answers' => 'required|array',
            'answers.*.question_id' => 'required|exists:questions,id,quiz_id,'.$quizId,
            'answers.*.answer' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Calculate score
        $score = 0;
        $totalMarks = 0;
        $answers = [];

        foreach ($request->answers as $answer) {
            $question = Question::find($answer['question_id']);
            $answers[$answer['question_id']] = $answer['answer'];

            if ($question && $answer['answer'] === $question->correct_answer) {
                $score += $question->marks;
            }
            $totalMarks += $question->marks;
        }

        // Determine if the employee passed (e.g., 60% or more)
        $passingPercentage = 60;
        $percentage = ($totalMarks > 0) ? ($score / $totalMarks) * 100 : 0;
        $passed = $percentage >= $passingPercentage;

        // Store the attempt
        $employee->quizzes()->syncWithoutDetaching([
            $quizId => [
                'answers' => json_encode($answers),
                'score' => $score,
                'passed' => $passed,
                'submitted_at' => now()
            ]
        ]);

        return response()->json([
            'message' => 'Quiz submitted successfully',
            'score' => $score,
            'total_marks' => $totalMarks,
            'passed' => $passed,
            'percentage' => round($percentage, 2)
        ], 200);
    }

    /**
     * Get the results of an employee's quiz attempt.
     *
     * @param  int  $courseId
     * @param  int  $quizId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getResults($courseId, $quizId)
    {
        $employee = auth('api')->user();
        $course = Course::find($courseId);
        $quiz = Quiz::where('course_id', $courseId)->find($quizId);

        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }

        if (!$quiz) {
            return response()->json(['message' => 'Quiz not found'], 404);
        }

        $attempt = $employee->quizzes()->where('quiz_id', $quizId)->first();
        if (!$attempt) {
            return response()->json(['message' => 'No quiz attempt found'], 404);
        }

        return response()->json([
            'message' => 'Quiz results retrieved successfully',
            'quiz' => $quiz,
            'score' => $attempt->pivot->score,
            'total_marks' => $quiz->total_marks,
            'passed' => $attempt->pivot->passed,
            'answers' => json_decode($attempt->pivot->answers, true),
            'submitted_at' => $attempt->pivot->submitted_at
        ], 200);
    }
}