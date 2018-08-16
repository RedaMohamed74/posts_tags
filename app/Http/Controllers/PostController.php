<?php
namespace App\Http\Controllers;

use App\Like;
use App\Post;
use App\Image;
use App\Tags;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class PostController extends Controller
{
    public function getDashboard()
    {
        $posts = Post::orderBy('created_at', 'desc')->get();
        $images = Image::orderBy('created_at', 'desc')->get();
        //echo dd($posts[0]->body);
        return view('dashboard', ['posts' => $posts,'images'=>$images]);
    }

    public function postCreatePost(Request $request)
    {
        $this->validate($request, [
            'body' => 'required|max:1000'
        ]);
        $post = new Post();
        $post->body = $request['body'];
       // echo dd($request['body']);
        $message = 'There was an error';
        if ($request->user()->posts()->save($post)) {
            $message = 'Post successfully created!';
        }
        return redirect()->route('dashboard')->with(['message' => $message]);
    }

    public function getDeletePost($post_id)
    {
        $post = Post::where('id', $post_id)->first();
        $image = Image::where('post_id', $post_id)->first();
        if (Auth::user() != $post->user) {
            return redirect()->back();
        }
            
        if($image!=null){
            $image->delete() and $post->delete();
        }else {
            $post->delete();
        }
        return redirect()->route('dashboard')->with(['message' => 'Successfully deleted!']);
    }

    public function postEditPost(Request $request)
    {
        function hashtag($string){
            $hash='#';
            $arr = explode(" ", $string);
            $arrc = count($arr);
            $i =0;
            while ($i < $arrc) {
                if(substr($arr[$i], 0 , 1)===$hash){
                     $arr[$i] = "<input hidden type='text' name='tag' value='".$arr[$i]."'><button type='submit' style='background:white;color:#337ab7; border:hidden;'>".$arr[$i]."</button>" ;
                }
                $i++;
            }
            $string = implode(" ",$arr);
            return $string;
        }


        $this->validate($request, [
            'body' => 'required'
        ]);
        $post = Post::find($request['postId']);
        if (Auth::user() != $post->user) {
            return redirect()->back();
        }
        $string = hashtag($request['body']);
        $post->body = $string;
        $post->update();
        return response()->json(['new_body' => $post->body], 200);
    }

    public function postTagsPost(Request $request)
    {
        $post_id = $request['postId'];
        $is_tag = $request['isTag'] === 'true';
        $update = false;
        $post = Post::find($post_id);
        if (!$post) {
            return null;
        }
        $user = Auth::user();
        $tag = $user->tags()->where('post_id', $post_id)->first();
        if ($tag) {
            $already_tag = $tag->tag;
            $update = true;
            if ($already_tag == $is_tag) {
                $tag->delete();
                return null;
            }
        } else {
            $tag = new Tags();
        }
        $tag->tag = $is_tag;
        $tag->user_id = $user->id;
        $tag->post_id = $post->id;
        if ($update) {
            $tag->update();
        } else {
            $tag->save();
        }
        return null;
    }

    //______________________add post and image_________________________

        public function postArticle(Request $request)
        {

         function hashtag($string){
            $hash='#';
            $arr = explode(" ", $string);
            $arrc = count($arr);
            $i =0;
            while ($i < $arrc) {
                if(substr($arr[$i], 0 , 1)===$hash){
                    $arr[$i] = "<input hidden type='text' name='tag' value='".$arr[$i]."'><button type='submit' style='background:white;color:#337ab7; border:hidden;'>".$arr[$i]."</button>" ;
                    //echo dd($arr[$i]);
                    
                }
                $i++;
            }
            $string = implode(" ",$arr);
            return $string;
        }

        $this->validate($request, [
            'body' => 'required|max:1000'
        ]);
        $post = new Post();
        $string = hashtag($request['body']);
        $post->body = $string;
       // echo dd($string);
        $message = 'There was an error';
        if ($request->user()->posts()->save($post)) {
            $message = 'Post successfully created!';
        }


        Auth::user()->posts()->save($post);
        // 
        for ($i = 1; $i < 100; $i++) {
            // echo dd($request[$i]);
                    if($request[$i]) {
                    $filenameWithExtention = $request->file($i)->getClientOriginalName();
                    $fileName = pathinfo($filenameWithExtention, PATHINFO_FILENAME);
                    $extention = $request->file($i)->getClientOriginalExtension();
                    $fileNameStore = $fileName . '_' . time() . '.' . $extention;
                    $path = $request->file($i)->storeAs('public/images', $fileNameStore);
                    $image = new Image();
                    $image->name = $fileNameStore;
                    $post->images()->save($image);
                    }
        }

              return redirect()->route('dashboard')->with(['message' => 'Successfully deleted!']);

              //-----------------------------------

    }

    public function getHashtags()
    {
        $tags = Tags::orderBy('created_at', 'desc')->where('tag',1)->get();
        $posts = Post::orderBy('created_at', 'desc')->get();
        $images = Image::orderBy('created_at', 'desc')->get();
        return view('hashtags', ['posts' => $posts,'images'=>$images,'tags'=>$tags]);
    }

    public function getSearch(Request $request){
       $posts=[];
       $post = Post::orderBy('created_at','desc')->get();
        if($request['tag']){
            $posts = Post::where('body','like','%'.$request['tag'].'%')->orderBy('created_at','desc')->get();
        }else{
            $posts = [];
        }
        
       if (empty($posts[0]->id)) {
         $posts = ["tt"];
       }elseif($posts[0]->id){
        }
        $images = Image::orderBy('created_at', 'desc')->get();
//echo dd($posts);
        return view('viewhashtags', ['posts' => $posts,'images'=>$images]);
    }
}