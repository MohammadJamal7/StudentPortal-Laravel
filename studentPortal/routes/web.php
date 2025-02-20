<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TestController;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return redirect()->action([StudentController::class, 'studentDash']);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

# tests
Route::get('/createSubject',TestController::class.'@createSubject');
Route::get('/getSubjects',TestController::class.'@getSubjects');
Route::get('/getUser',TestController::class.'@getUser');
Route::get('/createuser',TestController::class.'@createuser');
Route::get('/assign',StudentController::class.'@assign');
Route::get('/editSubject',TestController::class.'@editSubject');


## student routes 

Route::middleware('auth')->group(function (){
Route::get('/user/dash',StudentController::class.'@studentDash');

});


// Route::get('/admin/index',AdminController::class.'@index');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function() {
    Route::get('/', [AdminController::class, 'index'])->name('index');

    // User Management Routes
    Route::post('/user', [AdminController::class, 'store'])->name('users.store'); // Create user
    Route::get('/user/{user}/edit', [AdminController::class, 'edit'])->name('users.edit'); // Edit user
    Route::put('/user/{user}', [AdminController::class, 'update'])->name('users.update'); // Update user
    Route::delete('/user/{user}', [AdminController::class, 'destroy'])->name('users.destroy');


      // Subject Management Routes
      Route::post('/subject', [AdminController::class, 'createSubject'])->name('subjects.store'); // Create subject
      Route::post('/assign-subject', [AdminController::class, 'assignSubjectToStudent'])->name('subjects.assign'); // Assign subject to student
      Route::post('/set-mark', [AdminController::class, 'setMark'])->name('subjects.setMark'); // Set mark for student

      Route::get('/subjects/{user}', [AdminController::class, 'getAssignedSubjects'])
      ->name('get.subjects');



});
Route::get('/make', [AdminController::class, 'makeAdmin']);
