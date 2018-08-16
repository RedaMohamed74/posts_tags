<?php

namespace App\Http\Controllers\Admin;
use App\Admin;
use App\Image;
use App\Post;
use App\User;
use Illuminate\Http\Request;

//use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use App\Mail\AdminResetPassword;
use Carbon\Carbon;
use DB;
use Mail;
use Validator;

class AdminController extends Controller
{
    public function show()
	{
		$posts= DB::table('posts')->get();
		return view ('admin.home',compact('posts'));
	}

    public function getartMang()
	{
		$posts= DB::table('posts')->get();
        $images = Image::orderBy('created_at', 'desc')->get();
		return view ('admin.artMang',compact('posts','images'));
	}

    public function userpanel()
	{
		$users= DB::table('users')->get();
		return view ('admin.user_panel',compact('users'));
	}

	public function edit(post $post)
	{
		return view ('admin.edit', compact('post'));
	}

	public function update(Request $request , post $post)
	{
		//echo dd($post->id);
				$posts= DB::table('posts')->get();
        $images = Image::orderBy('created_at', 'desc')->get();

		$post=\DB::table('posts')
            ->where('id', $post->id)
            ->update(['body' => $request['body']]);

		//$post->update($request->all());
		return redirect('admin/artMang');
	}

    public function delete(post $post)
    {
        $post = Post::where('id', $post->id)->first();
        $image = Image::where('post_id', $post->id)->first();
        if($image!=null){
            $image->delete() and $post->delete();
        }else{
                  $post->delete();

        }
        return redirect('admin/artMang')->with(['message' => 'Successfully deleted!']);
    }

    public function update_role(Request $request ,User $user)
    {
    	\DB::table('users')
            ->where('id', $user->id)
            ->update(['role' => $request['role']]);
        if ($request['role']==1) {
        	$data = new Admin;
        	//echo dd($user);
            $data->name = $user->name;
            $data->email = $user->email;
            $data->password =$user->password;
            $data->save();
        }else {
        	$admin = Admin::where('email', $user->email)->first();
        	if ($admin != null) {
        		$admin->delete();
        	}
        	
        }
        return redirect('admin/userpanel');
    }

  public function getAdminregister()
	{
		$admins= DB::table('admins')->get();
		return view ('admin.adminReg',compact('admins'));
	}

  public function postAdminregister(Request $request)
  {
      $rules =[
        'name'     => ['required','string','max:255'],
        'email'    => ['required','string','email','max:255','unique:users'],
        'password' => ['required','string','min:6'],
      ];

      $validate = Validator::make($request->all(), $rules);
      if ($validate->fails()) {
        return redirect('admin/getAdminregister')->with(['message' => $validate->messages()]);
      }else{

          $data = new Admin;
          $data->name = $request['name'];
          $data->email = $request['email'];
          $data->password =bcrypt($request['password']);
          $data->save();

          $data = new User;
          $data->name = $request['name'];
          $data->email = $request['email'];
          $data->role = 1;
          $data->password =bcrypt($request['password']);
          $data->save();
 
        return redirect('admin/getAdminregister')->with(['message' => $validate->messages()]);
    }
  } 
}
