<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\User;
use App\Models\UserSubject;
use Illuminate\Http\Request;

use Illuminate\Container\Attributes\Auth as AttributesAuth;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class StudentController extends Controller
{
    
    function studentDash(){
        $user = FacadesAuth::user();
        if ($user->is_admin) {
            return redirect()->action([AdminController::class, 'index']);
        }
        $subjects = $user->subjects;
        return view('student.dash',compact('user','subjects'));
    }

  
}
