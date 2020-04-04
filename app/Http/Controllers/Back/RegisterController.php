<?php

namespace App\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\VerifyMail;
use Illuminate\Support\Facades\Validator;
// Models
use App\Models\User;
use DB;

class RegisterController extends Controller
{
    public function index(){
      return view('auth.register');
    }
    
    public function register(Request $req){
      $messages = [
        'required'  => 'You must enter :attribute',
        'confirmed' => 'Passwords do not match, try again'
      ];
    
      $validator = Validator::make($req ->all(), [
          'fullname' => 'required|max:60|regex:/^[a-zA-Z]+(?:\s[a-zA-Z]+)+$/', //regex allows letters and one space
          'email' => 'required|email|unique:users,email|max:50',
          'password' =>  [ 'required',
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
                        ],
          'terms' => 'required'
      ], $messages);
      
      if ($validator->fails()) {
        return redirect()
                  ->route('register.index')
                  ->withErrors($validator)
                  ->withInput();
      }
    
      // All ok, register user
      $user = new User;
      $user->fullname = $req->fullname;
      $user->email = $req->email;
      $user->password = bcrypt($req->password);
      $user->save();
            
      // Get registered user for email verification
      $user_data = [
        'id'    => $user->id,
        'name'  => $user->name,
        'email' => $user->email,
        'link'  => str_random(30)
      ];
      
      // Insert data to verify_user table
      DB::table('verify_users')->insert([
        'user_id' => $user_data['id'],
        'token' => $user_data['link']
      ]);
      
      // Send verif. email
      \Mail::send('emails.verify_user', $user_data, function($message) use ($user_data){
        $message->to($user_data['email']);
        $message->subject('laraAuth Activation Guide');
      });
      
      return redirect('login')->with('register_success', 'We sent an activation link to your email');
      
    
    
    }
    
    public function verifyUser($token){
      $check = DB::table('verify_users')->where('token', $token)->first();
      if (!is_null($check)) {
        $user = User::find($check->user_id);
        // check if user is already activated
        if ($user->verified == 1) {
          return redirect()->route('login.index')->with('register_success', 'User is already activated');
        }
        $user->update(['verified' => 1]);
        DB::table('verify_users')->where('token', $token)->delete();
        return redirect()->route('login.index')->with('User activated successfully');
      }
    }

    
}






