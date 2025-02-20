@extends('layouts.app')

@section('content')
<div class="min-vh-100 bg-light">
    @if($user->is_active)
        <div class="container py-4">
            <!-- Hero Section -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="h3 mb-1">Welcome Back, {{ $user->username }}!</h1>
                            <p class="text-muted small mb-0">Track your academic progress and achievements</p>
                        </div>
                        <div>
                            <span class="d-flex align-items-center text-success small">
                                <span class="position-relative me-2">
                                    <span class="position-absolute top-50 start-50 translate-middle p-1 bg-success border border-light rounded-circle">
                                        <span class="visually-hidden">Status</span>
                                    </span>
                                </span>
                                Active Account
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grid Layout -->
            <div class="row g-4">
                <!-- Profile Card -->
                <div class="col-lg-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="card-title mb-0">Profile Overview</h5>
                                <i class="bi bi-person text-muted"></i>
                            </div>
                            <div class="d-flex flex-column gap-3">
                                <div class="p-3 bg-light rounded">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-person-circle text-muted me-3"></i>
                                        <div>
                                            <div class="text-muted small">Username</div>
                                            <div class="fw-medium">{{ $user->username }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-3 bg-light rounded">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-envelope text-muted me-3"></i>
                                        <div>
                                            <div class="text-muted small">Email</div>
                                            <div class="fw-medium">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Academic Progress -->
                <div class="col-lg-8">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Academic Progress</h5>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col">Subject</th>
                                            <th scope="col">Pass Mark</th>
                                            <th scope="col">Your Mark</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($subjects as $subject)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-light rounded p-2 me-3 text-center" style="width: 40px;">
                                                        <span class="fw-medium">{{ strtoupper(substr($subject->name, 0, 1)) }}</span>
                                                    </div>
                                                    <span>{{ $subject->name }}</span>
                                                </div>
                                            </td>
                                            <td>{{ $subject->pass_mark }}</td>
                                            <td>
                                                @if(isset($subject->pivot->mark))
                                                    <div class="progress" style="height: 6px;">
                                                        <div class="progress-bar {{ $subject->pivot->mark >= $subject->pass_mark ? 'bg-success' : 'bg-danger' }}" 
                                                             role="progressbar" 
                                                             style="width: {{ min(($subject->pivot->mark / 100) * 100, 100) }}%" 
                                                             aria-valuenow="{{ $subject->pivot->mark }}" 
                                                             aria-valuemin="0" 
                                                             aria-valuemax="100"></div>
                                                    </div>
                                                    <small class="text-muted">{{ $subject->pivot->mark }}/100</small>
                                                @else
                                                    <span class="text-muted">Not graded</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if(isset($subject->pivot->mark))
                                                    @if($subject->pivot->mark >= $subject->pass_mark)
                                                        <span class="badge bg-success-subtle text-success">Passed</span>
                                                    @else
                                                        <span class="badge bg-danger-subtle text-danger">Failed</span>
                                                    @endif
                                                @else
                                                    <span class="badge bg-secondary-subtle text-secondary">Pending</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="alert alert-warning d-flex align-items-center" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <div>
                            <h4 class="alert-heading">Account Inactive</h4>
                            <p class="mb-0">This account is inactive, please wait for the administrator to activate your account.</p>
                        </div>
                    </div>
                    <!-- Optional: Add a card with basic profile info -->
                    <div class="card mt-4">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Profile Information</h5>
                            <div class="d-flex flex-column gap-2">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-person-circle text-muted me-3"></i>
                                    <div>
                                        <div class="text-muted small">Username</div>
                                        <div class="fw-medium">{{ $user->username }}</div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-envelope text-muted me-3"></i>
                                    <div>
                                        <div class="text-muted small">Email</div>
                                        <div class="fw-medium">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Make sure to include Bootstrap CSS and JS in your layout -->
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endpush
@endsection