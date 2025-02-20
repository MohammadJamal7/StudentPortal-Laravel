<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\User;
use Doctrine\Inflector\Rules\English\Rules;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

use function Pest\Laravel\json;

class TestController extends Controller
{
    function createSubject(){
        Subject::create(
            [
                'name'=>'English',
                'pass_mark'=>50
            ]
            );

            return 'subject created successfully';
    }

    function getSubjects(){
        $subjects = Subject::all();
        return response()->json($subjects);

    }

    function getUser(){
        $user = User::all();
        return $user;
    }

    function createuser(){
      $user =  User::create([
            'username'=>'ahmad',
            'email'=>'ahmadss@gmail.com',
            'password'=>'234234@Mm',
        ]);

        return response()->json($user);
    }

    ## regsiter user function

    public function save(Request $request){
        $request->validate([
            'username' => ['required', 'string', 'min:8','unique:'.User::class,],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', ],
        ]);
        $username = $request->input('username'); 
        $user = User::create([
            'username' => $username,
            'email' => $request->email,
            'password' => Hash::make($request->string('password')),
        ]);
       
        // event(new Registered($user));

        // Auth::login($user);

        return redirect()->route('login')->with('status', 'Registration successful. Please log in.');

    }

    public function editSubject(){
        $subject = Subject::find(4);
        $subject->pass_mark = 60;
        $subject->save();
        return response()->json($subject);
    }
    
}
