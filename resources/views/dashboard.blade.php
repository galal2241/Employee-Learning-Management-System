@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Welcome to the Dashboard</h1>

        <!-- Courses Section -->
        <div class="card mb-4">
            <div class="card-header">
                <h3>My Courses</h3>
            </div>
            <div class="card-body">
                @if($courses->isEmpty())
                    <p>No courses enrolled yet.</p>
                @else
                    <div class="row">
                        @foreach($courses as $course)
                            <div class="col-md-4 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $course->title }}</h5>
                                        <p class="card-text">{{ \Illuminate\Support\Str::limit($course->description, 100) }}</p>
                                        <p class="card-text">
                                            Progress: {{ $course->pivot->progress }}%
                                            @if($course->pivot->completed)
                                                <span class="badge bg-success">Completed</span>
                                            @endif
                                        </p>
                                        <a href="#" class="btn btn-primary">View Details</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Lessons Section -->
        <div class="card mb-4">
            <div class="card-header">
                <h3>Recent Lessons</h3>
            </div>
            <div class="card-body">
                @if($lessons->isEmpty())
                    <p>No lessons available.</p>
                @else
                    <ul class="list-group">
                        @foreach($lessons as $lesson)
                            <li class="list-group-item">
                                {{ $lesson->title }} (Course: {{ $lesson->course->title }})
                                @if($lesson->pivot->completed)
                                    <span class="badge bg-success">Completed</span>
                                @endif
                                <a href="#" class="btn btn-sm btn-outline-primary float-end">View</a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>

        <!-- Quizzes Section -->
        <div class="card mb-4">
            <div class="card-header">
                <h3>Upcoming Quizzes</h3>
            </div>
            <div class="card-body">
                @if($quizzes->isEmpty())
                    <p>No quizzes available.</p>
                @else
                    <ul class="list-group">
                        @foreach($quizzes as $quiz)
                            <li class="list-group-item">
                                {{ $quiz->title }} (Course: {{ $quiz->course->title }})
                                @if($quiz->pivot->passed)
                                    <span class="badge bg-success">Passed (Score: {{ $quiz->pivot->score }})</span>
                                @elseif($quiz->pivot->submitted_at)
                                    <span class="badge bg-danger">Failed (Score: {{ $quiz->pivot->score }})</span>
                                @else
                                    <span class="badge bg-warning">Pending</span>
                                @endif
                                <a href="#" class="btn btn-sm btn-outline-primary float-end">Take Quiz</a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>

        <!-- Certificates Section -->
        <div class="card">
            <div class="card-header">
                <h3>My Certificates</h3>
            </div>
            <div class="card-body">
                @if($certificates->isEmpty())
                    <p>No certificates earned yet.</p>
                @else
                    <ul class="list-group">
                        @foreach($certificates as $certificate)
                            <li class="list-group-item">
                                Certificate for {{ $certificate->course->title }}
                                (Issued: {{ $certificate->issued_date->format('Y-m-d') }})
                                <a href="#" class="btn btn-sm btn-outline-success float-end">Download PDF</a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
@endsection