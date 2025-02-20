@extends('layouts.app')





@section('content')
<div class="container py-4">
    <div class="container py-4">
        <!-- Success or Error Alert -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>
        @endif
    </div>

   <!-- Alert Section -->
<div class="alert alert-info alert-dismissible fade show d-flex align-items-center" role="alert">
    <i class="bi bi-info-circle-fill me-3 fs-3"></i>
    <div>
        <h4 class="alert-heading text-uppercase fw-bold">Administrator Panel</h4>
        <p class="mb-0">You can manage student data, subjects, and marks from this panel. All actions are quick and easy to access.</p>
    </div>
</div>

<!-- Buttons for Managing Users and Subjects -->
<div class="d-flex flex-wrap gap-3 justify-content-start mb-4">
    <button class="btn btn-md btn-primary rounded-pill d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#createUserModal">
        <i class="bi bi-person-plus-fill"></i> Create New User
    </button>
    <button class="btn btn-md btn-success rounded-pill d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#createSubjectModal">
        <i class="bi bi-file-earmark-plus-fill"></i> Create New Subject
    </button>
    <button class="btn btn-md btn-info rounded-pill d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#assignSubjectModal">
        <i class="bi bi-person-lines-fill"></i> Assign Subject to Student
    </button>
    <button class="btn btn-md btn-warning rounded-pill d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#setMarkModal">
        <i class="bi bi-pencil-square"></i> Set Mark
    </button>
</div>


    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title mb-3">Students Table</h5>
            <div style="height: 265px; overflow-y: auto;">
                <table class="table table-hover align-middle" style="margin-bottom: 0;">
                    <thead class="table-light" style="position: sticky; top: 0; z-index: 1; background-color: #f8f9fa;">
                        <tr>
                            <th scope="col" style="height: 45px;">Username</th>
                            <th scope="col">Email</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr style="height: 44px;">
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->is_active ? 'Active' : 'Inactive' }}</td>
                            <td>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}">Edit</button>
                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteUserModal{{ $user->id }}">Delete</button>
                            </td>
                        </tr>
    
                        <!-- Edit User Modal -->
                        <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" aria-labelledby="editUserModalLabel{{ $user->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editUserModalLabel{{ $user->id }}">Edit User</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="username" class="form-label">Username</label>
                                                <input type="text" class="form-control" id="username" name="username" value="{{ $user->username }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="is_active" class="form-label">Activate Account</label>
                                                <select class="form-select" id="is_active" name="is_active" required>
                                                    <option value="1" {{ $user->is_active ? 'selected' : '' }}>Active</option>
                                                    <option value="0" {{ !$user->is_active ? 'selected' : '' }}>Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
    
                        <!-- Delete User Modal -->
                        <div class="modal fade" id="deleteUserModal{{ $user->id }}" tabindex="-1" aria-labelledby="deleteUserModalLabel{{ $user->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteUserModalLabel{{ $user->id }}">Delete User</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure you want to delete this user?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modals for Create User, Create Subject, Assign Subject, Set Mark -->

<!-- Create New User Modal -->
<div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createUserModalLabel">Create New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <!-- Username Field -->
                    <div class="mb-3">
                        <label for="new_username" class="form-label">Username</label>
                        <input type="text" class="form-control @error('username') is-invalid @enderror" id="new_username" name="username" value="{{ old('username') }}" required>
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div class="mb-3">
                        <label for="new_email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="new_email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="mb-3">
                        <label for="new_password" class="form-label">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="new_password" name="password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Confirm Password Field -->
                    <div class="mb-3">
                        <label for="new_password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="new_password_confirmation" name="password_confirmation" required>
                        @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Activation Status -->
                    <div class="mb-3">
                        <label for="new_is_active" class="form-label">Activate Account</label>
                        <select class="form-select @error('is_active') is-invalid @enderror" id="new_is_active" name="is_active" required>
                            <option value="1" {{ old('is_active') == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('is_active')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create User</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Create New Subject Modal -->
<div class="modal fade" id="createSubjectModal" tabindex="-1" aria-labelledby="createSubjectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createSubjectModalLabel">Create New Subject</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.subjects.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <!-- Subject Name Field -->
                    <div class="mb-3">
                        <label for="subject_name" class="form-label">Subject Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="subject_name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Pass Mark Field -->
                    <div class="mb-3">
                        <label for="pass_mark" class="form-label">Pass Mark</label>
                        <input type="number" class="form-control @error('pass_mark') is-invalid @enderror" id="pass_mark" name="pass_mark" value="{{ old('pass_mark') }}" required>
                        @error('pass_mark')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create Subject</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Assign Subject to Student Modal -->
<div class="modal fade" id="assignSubjectModal" tabindex="-1" aria-labelledby="assignSubjectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignSubjectModalLabel">Assign Subject to Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.subjects.assign') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <!-- Select Student -->
                    <div class="mb-3">
                        <label for="student_id" class="form-label">Select Student</label>
                        <select class="form-select @error('user_id') is-invalid @enderror" id="student_id" name="user_id" required>
                            <option value="">Select Student</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->username }}</option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Select Subject -->
                    <div class="mb-3">
                        <label for="subject_id" class="form-label">Select Subject</label>
                        <select class="form-select @error('subject_id') is-invalid @enderror" id="subject_id" name="subject_id" required>
                            <option value="">Select Subject</option>
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                            @endforeach
                        </select>
                        @error('subject_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Assign Subject</button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- Set Marks for Student Modal -->
<div class="modal fade" id="setMarkModal" tabindex="-1" aria-labelledby="setMarkModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="setMarkModalLabel">Set Marks for Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.subjects.setMark') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <!-- Select Student -->
                    <div class="mb-3">
                        <label for="student_id" class="form-label">Select Student</label>
                        <select class="form-select" id="student_id" name="user_id" required>
                            <option value="">Select Student</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->username }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Select Subject (Dynamically populated based on selected student) -->
                    <div class="mb-3">
                        <label for="subject_id" class="form-label">Select Subject</label>
                        <select class="form-select" id="subject_id" name="subject_id" required>
                            <option value="">Select a Subject</option>
                        </select>
                    </div>

                    <!-- Mark -->
                    <div class="mb-3">
                        <label for="mark" class="form-label">Mark</label>
                        <input type="number" class="form-control @error('mark') is-invalid @enderror" id="mark" name="mark" value="{{ old('mark') }}" required>
                        @error('mark')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Set Mark</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // JavaScript to filter subjects based on selected student
    const users = @json($users); // Pass all users with their subjects to JS
    
    
   // Add this at the top of your script to verify data
console.log('Initial users data:', users);

$('#setMarkModal #student_id').on('change', function() {
    const studentId = $(this).val();
    console.log('Selected student ID:', studentId);
    
    const selectedUser = users.find(user => user.id == studentId);
    console.log('Selected user data:', selectedUser);
    
    const subjectDropdown = $('#setMarkModal #subject_id');
    subjectDropdown.empty().append('<option value="">Select a Subject</option>');
    
    if (selectedUser?.subjects?.length) {
        selectedUser.subjects.forEach(subject => {
            subjectDropdown.append(`<option value="${subject.id}">${subject.name}</option>`);
        });
    }
});
</script>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


@endpush
@endsection
