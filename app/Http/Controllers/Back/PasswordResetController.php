<?php

namespace App\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Validator;
// Models
use App\Models\ResetPassword;
use App\Models\User;

class PasswordResetController extends Controller
{
    public function index(){
      return view('auth.forgot_password');
    }
    
    public function resetPost(Request $req){
      $req->validate([
        'email' => 'required|email'
      ]);
    
      // Check email exsitence
      $user = User::where('email', $req->email)->get()->count();
      if ($user != 1) {
        return redirect()->route('reset.index')->with('reset_fail', 'No such user found');
      }
      
      // Insert data
      $rp = new ResetPassword();
      $rp->email = $req->email;
      $rp->token = str_random(30);
      $rp->save();
      
      $data = [
        'email' => $rp->email,
        'link' => $rp->token
      ];
      
      // Send email
      \Mail::send('emails.reset_password', $data, function($message) use ($data){
        $message->to($data['email']);
        $message->subject('laraAuth Password Reset');
      });
      
      return redirect()->route('reset.index')->with('email_success', 'Check out your email (:');
    }
    
    public function resetPassword($token){
      $check = ResetPassword::where('token', $token)->first();
      
      if (is_null($check)) {
        return redirect()->route('reset.index')->with('reset_fail', 'Unable to send email, try again');
      }
      
      return redirect()->route('recover', $token);
    }
    
  
    public function recoverPassword($token){
      $data['user_token'] = $token;
      return view('auth.recover_password', $data);
    }
    
    public function recoverPasswordPost(Request $req){
      $messages = [
        'required'  => 'You must enter :attribute',
        'confirmed' => 'Passwords do not match, try again'
      ];
    
      $validator = Validator::make($req ->all(), [
        'password' => ['required',
                       'confirmed',
                       function ($attribute, $password, $fail) {
                          $uppercase = preg_match('@[A-Z]@', $password);
                          $lowercase = preg_match('@[a-z]@', $password);
                          $number    = preg_match('@[0-9]@', $password);
                          # $ % ^ @ ! & * ( ) + = - [ ] \ ' ; , . / { } | \ " : ? ~
                          $symbol =  preg_match('/[#$%^@!&*()+=\-\[\]\';,.\/{}|":?~\\\\]/', $password);

                          if(!$uppercase || !$lowercase || !$number || !$symbol || strlen($password) < 6) {
                            $fail('Password must be at least 6 characters long including an uppercase, lowercase letter along with a number and symbol.');
                          }
                        } ,
                    ]
                  ], $messages);
    
        if ($validator->fails()) {
          return redirect()->back();
        }          
        
        // Find user
        $user_token = ResetPassword::where('token', $req->user_token)->first(); 
        // Get id of user
        $user_id =  $user_token->getUser->id;
                
        
        // Update password
        DB::table('users')->where('id', $user_id)->update([
          'password' => bcrypt($req->password)
        ]);
        
        // Delete token
        $user_token->delete();
        
        return redirect()->route('login.index')->with('register_success', 'All done, use your new password to login');
    
    }
    
}
