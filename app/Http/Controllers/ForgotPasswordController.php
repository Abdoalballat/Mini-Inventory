<?php

namespace App\Http\Controllers;

use App\Mail\otp_email;
use App\Models\login;
// use Carbon\Carbon;
use Hash;
use Illuminate\Support\Carbon;
use Illuminate\Contracts\Support\ValidatedData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Redirect;

class ForgotPasswordController extends Controller
{
    public function showForgotForm(){
        
        return view('auth.forgot-password');
    }
    public function sendOtp(Request $request){
        $validatedData = $request->validate([
            'email' =>'required|string|max:255'
        ]);
        $user =login::where('email',$validatedData['email'])->first();
        // **************************************ratr
        $throttleKey= 'send-otp' . $request->ip();
        if(RateLimiter::tooManyAttempts($throttleKey,3))
            {
            $seconds=RateLimiter::availableIn($throttleKey);
            return back()->with('Failed','Try Again After 2 Minuts')->with('retry_after', $seconds);
            }
            RateLimiter::hit($throttleKey,60);
        if( $user)
        {
        $otp=rand(111111,999999);
        $hashed_otp =Hash::make($otp);
        $otp_expires_at= Carbon::now()->addMinutes(10);
        $user->update([
            'otp_code'=> $hashed_otp,
            'otp_expires_at' =>$otp_expires_at,
        ]);
            Mail::to($user->email)->send(new otp_email($otp));
            return redirect()->route('password.reset', ['email' => $user->email])
            ->with('Succes', 'OTP code has been sent to your email.');
        }
        
        return Redirect()->route('login.page')->with('Faield','wrong email');


        }
    public function verify_otp(Request $request){
            $otp_data= $request->validate([
            'email'    => 'required|email',
            'otp_code' => 'required|string',
            ]);
            // ----------------------------------------------------------------------------rate
            $throttleKey='verify_otp' . $request->email;
            if(RateLimiter::tooManyAttempts($throttleKey,2))
                {
                    $seconds =RateLimiter::availableIn($throttleKey);
                        return back()->with('Failed','Try Again After 2 Minuts')->with('retry_after', $seconds);;
                }

            $user =login::where('email',$otp_data['email'])->first();
            if(!$user)
                {
                return redirect()->route('password.request')->with('Failed', 'User not found.');
                }


            if(!Hash::check($otp_data['otp_code'],$user->otp_code)){
                // dd(['send'=>$otp_data['otp_code'],
                // 'otp'=>$user->otp_code]);
                RateLimiter::hit($throttleKey,180);
                return back()->with('Failed', 'Invalid OTP code.');}

                RateLimiter::clear($throttleKey);
                
            if(Carbon::now()->greaterThan($user->otp_expires_at))
                {
                    return redirect()->route('password.request')->with('Failed', 'OTP has expired.');
                }

            session(['reset_password_email' => $user->email]);
            return redirect()->route('password.reset.form');

        }

public function showVerifyOtpForm(Request $request)
{
    if (! $request->has('email') || empty($request->email)) {
        return redirect()->route('password.request')->with('Failed', 'Please enter your email first.');
    }

    return view('auth.verify-otp');
}    
    public function showResetForm(){
            if (!session('reset_password_email')) {
            return redirect()->route('password.request')->with('error', 'Unauthorized access.');
            }
            return view('auth.reset-password');    
            }

        
    public function resetPassword(request $request) {
        
            $session_validate = session('reset_password_email');
            if(!$session_validate){
                return redirect()->route('password.request')->with('error', 'Session expired. Please try again.');
            }
            $validated_data=$request->validate([
                'password' => 'required|string|min:8|confirmed',
            ]);
            $user =login::where('email',$session_validate)->first();
            if (! $user) {
                return redirect()->route('password.request')->with('error', 'Unauthorized');
            }

            $user->update([
            'password'       => Hash::make($validated_data['password']),
            'otp_code'       => null,
            'otp_expires_at' => null,
            ]  );
            session()->forget('reset_password_email');
            return redirect()->route('login.page')->with('Succes', 'Password has been reset successfully. You can now login.');
            }
}
