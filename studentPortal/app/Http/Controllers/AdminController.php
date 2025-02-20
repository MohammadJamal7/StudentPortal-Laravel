<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\User;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    

   // Show all users
   public function index()
   {
       $currentUser = FacadesAuth::user();
       if (!$currentUser->is_admin) {
            return redirect()->route('login');
       }
       $users = User::where('is_admin',false)->with('subjects')->get();
       $subjects = Subject::all();
       return view('admin.index', compact('users','subjects'));
   }

   // Create a new user
   public function store(Request $request)
   {
      # Validate the input
       $request->validate([
           'username' => 'required|string|unique:users|min:8',
           'email' => 'required|string|email|unique:users',
           'is_active' => 'required|boolean',
           'password' => 'required|string|confirmed|min:8',
       ]);

       // Create the user
       User::create([
           'username' => $request->username,
           'email' => $request->email,
           'is_active' => $request->is_active,
           'password' => bcrypt($request->password),
       ]);

       return redirect()->route('admin.index')->with('success', 'User created successfully');
   }

   // Edit user details
   public function edit(User $user)
   {
       return response()->json($user);
   }

   // Update user details
   public function update(Request $request, User $user)
   {
       // Validate the input
       $request->validate([
           'username' => 'required|string',
           'email' => 'required|string|email',
           'is_active' => 'required|boolean',
       ]);

       // Update the user
       $user->update([
           'username' => $request->username,
           'email' => $request->email,
           'is_active' => $request->is_active,
       ]);

       return redirect()->route('admin.index')->with('success', 'User updated successfully');
   }

   // Delete a user
   public function destroy(User $user)
   {
       // Delete the user
       $user->delete();

       return redirect()->route('admin.index')->with('success', 'User deleted successfully');
   }

   // Create a new subject
   public function createSubject(Request $request)
   {
       // Validate the input
       $request->validate([
           'name' => 'required|string|unique:subjects',
           'pass_mark' => 'required|integer',
       ]);

       // Create the subject
       Subject::create([
           'name' => $request->name,
           'pass_mark' => $request->pass_mark,
       ]);

       return redirect()->route('admin.index')->with('success', 'Subject created successfully');
   }

   public function assignSubjectToStudent(Request $request)
   {
       // Validate the input
       $request->validate([
           'user_id' => 'required|exists:users,id',
           'subject_id' => 'required|exists:subjects,id',
       ]);
   
       // Get the user
       $user = User::find($request->user_id);
   
       // Check if the subject is already assigned to the user
       if ($user->subjects()->where('subject_id', $request->subject_id)->exists()) {
           return redirect()->route('admin.index')->with('error', 'This subject is already assigned to the student.');
       }
   
       // If subject is not already assigned, then assign it
       $user->subjects()->attach($request->subject_id);
   
       return redirect()->route('admin.index')->with('success', 'Subject assigned to student successfully');
   }
   
   

   public function getAssignedSubjects(User $user)
   {
       $assignedSubjects = $user->subjects;
       return response()->json($assignedSubjects);
   }

 
   // Set marks for a student
   public function setMark(Request $request)
   {
       // Validate the input
       $request->validate([
           'user_id' => 'required|exists:users,id',
           'subject_id' => 'required|exists:subjects,id',
           'mark' => 'required|integer|between:0,100',
       ]);

       // Assign the mark to the student
       $user = User::find($request->user_id);
       $user->subjects()->updateExistingPivot($request->subject_id, ['mark' => $request->mark]);

       return redirect()->route('admin.index')->with('success', 'Mark set successfully');
   }
   
   public function makeAdmin(){
   $user = User::create([
      'username' => 'admin',
      'email' => 'admin@system.com',
      'password' => 'admin123',
      'is_admin' => true
    ]);

    return response()->json($user);
   }
}
