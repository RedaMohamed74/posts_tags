<?php
namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Query\Builder;


	class UserController extends Controller
	{
		
		
		function postSignUp(Request $request)
		{
			$this->validate($request,[
				'email'=>'required|email|unique:users',
				'name'=>'required|max:120',
				'password'=>'required|min:4'
				]);
			$email = $request['email'];
			$name = $request['name'];
			$password = bcrypt($request['password']);

			$user = new User();
			$user ->email=$email;
			$user ->name=$name;
			$user ->password=$password;

			Auth::login($user);
			$user ->save();

			return redirect()->route('dashboard');

		}
		function postSignIn(Request $request)
		{
			if (Auth::attempt(['email'=>$request['email'],'password'=>$request['password']])) {
				return redirect()->route('dashboard');
			}else{
				return redirect()->back();
			}
		}

		public function LogOut()
		{
			Auth::logout();
			return redirect()->route('home');
		}
		public function getAccount(){
            return view('account',['user'=>Auth::user()])  ;
        }
        public function postSaveAccount(Request $request){
            $this->validate($request,[
                'name'=>'required|max:120'
            ]);
            $user=Auth::user();
            $user->name=$request['name'];
            $user->update();
            $file=$request->file('image');
            $filename=$request['name'].'-'.$user->id .'.jpg';
            if($file)
            {
                Storage::disk('local')->put($filename,File::get($file));
            }
            return redirect()->route('account');
        }

        public function getUserImage($filename){
            $file=Storage::disk('local')->get($filename);
            return new Response($file,200);
        }
	}

  