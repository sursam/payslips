<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Rules\RecaptchaRule;
use Illuminate\Http\Request;
use DB; 
use Carbon\Carbon; 
use Mail; 
use Illuminate\Support\Str;

class ForgotPasswordController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function adminForgotPassword()
    {
        $this->setPageTitle('Forgot Password');
        return view('auth.admin.forgot-password');
    }
    public function councilForgotPassword()
    {
        $this->setPageTitle('Forgot Password');
        return view('auth.council.passwords.email');
    }

    /**
     * Validate the email for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function validateEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'recaptcha'=> ['required',new RecaptchaRule('forget')]
        ]);
    }

    /**
       * Write code on Method
       *
       * @return response()
       */
      public function submitAdminForgotPassword(Request $request)
      {
            $request->validate([
                'email' => 'required|email|exists:users',
                'recaptcha'=> ['required',new RecaptchaRule('forget')]
            ]);
  
          $token = Str::random(64);
  
          DB::table('password_resets')->insert([
              'email' => $request->email, 
              'token' => $token, 
              'created_at' => Carbon::now()
            ]);
  
          Mail::send('mail.forgot-password', ['token' => $token, 'email' => $request->email], function($message) use($request){
              $message->to($request->email);
              $message->subject('Reset Password');
          });
  
          return $this->responseRedirectBack('We have e-mailed your password reset link!', 'success', true, true);
      }

    
}
