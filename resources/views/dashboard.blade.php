@extends('layouts.app')

@section('content')
    <div class="container dashboard-container">
        <!-- Header Section -->
        <div class="dashboard-header mb-5">
            <h1 class="display-4 fw-bold">Welcome Back</h1>
            <p class="lead text-muted">Here's your learning progress overview</p>
            
            <!-- Progress Summary Cards -->
            <div class="row progress-summary mt-4">
                <div class="col-md-3 mb-4">
                    <div class="card stat-card bg-primary text-white">
                        <div class="card-body">
                            <div class="stat-icon">
                                <i class="fas fa-book-open"></i>
                            </div>
                            <h5 class="card-title">Enrolled Courses</h5>
                            <h2 class="card-value">{{ $courses->count() }}</h2>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 mb-4">
                    <div class="card stat-card bg-success text-white">
                        <div class="card-body">
                            <div class="stat-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <h5 class="card-title">Completed</h5>
                            <h2 class="card-value">{{ $courses->where('pivot.completed', true)->count() }}</h2>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 mb-4">
                    <div class="card stat-card bg-info text-white">
                        <div class="card-body">
                            <div class="stat-icon">
                                <i class="fas fa-certificate"></i>
                            </div>
                            <h5 class="card-title">Certificates</h5>
                            <h2 class="card-value">{{ $certificates->count() }}</h2>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 mb-4">
                    <div class="card stat-card bg-warning text-dark">
                        <div class="card-body">
                            <div class="stat-icon">
                                <i class="fas fa-tasks"></i>
                            </div>
                            <h5 class="card-title">Pending Quizzes</h5>
                            <h2 class="card-value">{{ $quizzes->where('pivot.submitted_at', null)->count() }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row">
            <!-- Left Column -->
            <div class="col-lg-8">
                <!-- Courses Section -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="mb-0"><i class="fas fa-book me-2 text-primary"></i> My Courses</h3>
                            <a href="#" class="btn btn-sm btn-outline-primary">View All</a>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        @if($courses->isEmpty())
                            <div class="empty-state">
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ5cxfMS810nRmT_-m1PT10AGUUSf8hs-FFbYzwPX5klW8sW9SXR4KLYruOQp-zFCNww-Y&usqp=CAU" alt="No courses" class="img-fluid" style="max-height: 200px;">
                                <h5 class="mt-3">No courses enrolled yet</h5>
                                <p class="text-muted">Start your learning journey by enrolling in courses</p>
                                <a href="#" class="btn btn-primary mt-2">Browse Courses</a>
                            </div>
                        @else
                            <div class="row">
                                @foreach($courses->take(3) as $course)
                                    <div class="col-md-4 mb-4">
                                        <div class="course-card card h-100 border-0 shadow-sm hover-shadow transition">
                                            <div class="course-badge">
                                                @if($course->pivot->completed)
                                                    <span class="badge bg-success">Completed</span>
                                                @else
                                                    <span class="badge bg-info">In Progress</span>
                                                @endif
                                            </div>
                                            <img src="{{ $course->image_url ?? asset('images/course-placeholder.jpg') }}" class="card-img-top" alt="{{ $course->title }}">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $course->title }}</h5>
                                                <p class="card-text text-muted">{{ \Illuminate\Support\Str::limit($course->description, 80) }}</p>
                                                
                                                <div class="progress mb-3">
                                                    <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $course->pivot->progress }}%" 
                                                        aria-valuenow="{{ $course->pivot->progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <small class="text-muted">Progress: {{ $course->pivot->progress }}%</small>
                                            </div>
                                            <div class="card-footer bg-white border-top-0">
                                                <a href="#" class="btn btn-sm btn-outline-primary w-100">Continue</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Lessons Section -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="mb-0"><i class="fas fa-play-circle me-2 text-success"></i> Recent Lessons</h3>
                            <a href="#" class="btn btn-sm btn-outline-success">View All</a>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        @if($lessons->isEmpty())
                            <div class="empty-state py-4">
                                <i class="fas fa-video-slash text-muted fa-3x mb-3"></i>
                                <h5>No lessons available</h5>
                                <p class="text-muted">Start learning to see your recent lessons here</p>
                            </div>
                        @else
                            <div class="list-group list-group-flush">
                                @foreach($lessons->take(5) as $lesson)
                                    <a href="#" class="list-group-item list-group-item-action border-0 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="lesson-icon me-3">
                                                <i class="fas fa-play-circle text-success"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="d-flex justify-content-between">
                                                    <h6 class="mb-1">{{ $lesson->title }}</h6>
                                                    <small class="text-muted">{{ $lesson->duration }} min</small>
                                                </div>
                                                <small class="text-muted">Course: {{ $lesson->course->title }}</small>
                                            </div>
                                            @if($lesson->pivot->completed)
                                                <span class="badge bg-success ms-2">Completed</span>
                                            @else
                                                <span class="badge bg-warning ms-2">Pending</span>
                                            @endif
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-lg-4">
                <!-- Quizzes Section -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom-0">
                        <h3 class="mb-0"><i class="fas fa-question-circle me-2 text-danger"></i> Quizzes</h3>
                    </div>
                    <div class="card-body pt-0">
                        @if($quizzes->isEmpty())
                            <div class="empty-state py-4">
                                <i class="fas fa-check-circle text-muted fa-3x mb-3"></i>
                                <h5>No quizzes available</h5>
                                <p class="text-muted">You don't have any quizzes right now</p>
                            </div>
                        @else
                            <div class="list-group list-group-flush">
                                @foreach($quizzes->take(3) as $quiz)
                                    <div class="list-group-item border-0 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="quiz-icon me-3">
                                                <i class="fas fa-question-circle text-danger"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">{{ $quiz->title }}</h6>
                                                <small class="text-muted">Course: {{ $quiz->course->title }}</small>
                                            </div>
                                            @if($quiz->pivot->passed)
                                                <span class="badge bg-success ms-2">Passed ({{ $quiz->pivot->score }}%)</span>
                                            @elseif($quiz->pivot->submitted_at)
                                                <span class="badge bg-danger ms-2">Failed ({{ $quiz->pivot->score }}%)</span>
                                            @else
                                                <button class="btn btn-sm btn-outline-danger">Take Quiz</button>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="text-center mt-3">
                                <a href="#" class="btn btn-sm btn-outline-danger">View All Quizzes</a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Certificates Section -->
                <div class="card shadow-sm">
                    <div class="card-header bg-white border-bottom-0">
                        <h3 class="mb-0"><i class="fas fa-certificate me-2 text-warning"></i> Certificates</h3>
                    </div>
                    <div class="card-body pt-0">
                        @if($certificates->isEmpty())
                            <div class="empty-state py-4">
                                <i class="fas fa-certificate text-muted fa-3x mb-3"></i>
                                <h5>No certificates yet</h5>
                                <p class="text-muted">Complete courses to earn certificates</p>
                            </div>
                        @else
                            <div class="list-group list-group-flush">
                                @foreach($certificates->take(3) as $certificate)
                                    <div class="list-group-item border-0 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="certificate-icon me-3">
                                                <i class="fas fa-certificate text-warning"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">{{ $certificate->course->title }}</h6>
                                                <small class="text-muted">Issued: {{ $certificate->issued_date->format('M d, Y') }}</small>
                                            </div>
                                            <a href="#" class="btn btn-sm btn-outline-warning">Download</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="text-center mt-3">
                                <a href="#" class="btn btn-sm btn-outline-warning">View All Certificates</a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="card shadow-sm mt-4">
                    <div class="card-header bg-white border-bottom-0">
                        <h3 class="mb-0"><i class="fas fa-bolt me-2 text-info"></i> Quick Actions</h3>
                    </div>
                    <div class="card-body pt-0">
                        <div class="d-grid gap-2">
                            <a href="#" class="btn btn-outline-primary text-start">
                                <i class="fas fa-search me-2"></i> Browse Courses
                            </a>
                            <a href="#" class="btn btn-outline-success text-start">
                                <i class="fas fa-bookmark me-2"></i> Saved Courses
                            </a>
                            <a href="#" class="btn btn-outline-info text-start">
                                <i class="fas fa-chart-line me-2"></i> Progress Report
                            </a>
                            <a href="#" class="btn btn-outline-warning text-start">
                                <i class="fas fa-cog me-2"></i> Account Settings
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .dashboard-container {
            max-width: 1400px;
            padding-top: 2rem;
            padding-bottom: 3rem;
        }
        
        .dashboard-header {
            padding: 1.5rem;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 0.5rem;
        }
        
        .stat-card {
            border-radius: 0.5rem;
            border: none;
            transition: transform 0.3s ease;
            height: 100%;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-icon {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        
        .card-value {
            font-weight: 700;
            margin: 0.5rem 0;
        }
        
        .course-card {
            transition: all 0.3s ease;
            border-radius: 0.5rem;
            overflow: hidden;
        }
        
        .course-card:hover {
            transform: translateY(-5px);
        }
        
        .course-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 1;
        }
        
        .empty-state {
            text-align: center;
            padding: 2rem 0;
        }
        
        .hover-shadow {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        
        .hover-shadow:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        
        .progress-summary .card {
            cursor: pointer;
        }
        
        .list-group-item {
            border-left: 0;
            border-right: 0;
        }
        
        .list-group-item:first-child {
            border-top: 0;
        }
        
        .list-group-item:last-child {
            border-bottom: 0;
        }
    </style>
@endsection