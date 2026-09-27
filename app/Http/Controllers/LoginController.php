<?php

namespace App\Http\Controllers;

use App\Models\login;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class LoginController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function register(Request $request)
    {
        $user= $request->validate([
        'username'=>'string|required|max:255',
        'email'=>'string|unique:login,email|email|required|max:35',
        'password'=>'string|required|min:8|confirmed',
        ]);
        $user =login::create([
            'username'=> $user['username'],
            'email'=> $user['email'],
            'password'=>Hash::make($user['password'])

        ]);
        return response()->json(['Succes',$user],200);
        // return redirect('login')->with('Succes','welcome');
        }
        
    public function login(request $request){

    $user = $request->validate([
                // 'username'=>'string|max:255',
                'email'=>'string|email|required|max:35',
                'password'=>'string|required',
                ]);
    if(!Auth::attempt($user))
    {
        return back()->withErrors(['email'=>'wrong email or password.',])->onlyInput('email');
    }
    else
        {
            $request->session()->regenerate();


        return redirect()->route('products.index')->with('Succes', 'Welcome'.' '.Auth::user()->username );

        }


    }
            
            /**
             * Store a newly created resource in storage.
            */
            public function logout(Request $request)
            {   
                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('login.page')->with('Succes', 'Log Out Successfully');

                // $request->user()->currentAccessToken()->delete();
                // return redirect('login')->with('Succes','welcome');
                // return response()->json(['message'=>'Logout_succes'],200);
    }   

    public function showLoginForm()
    {
        return view('auth.login');
    }


}
