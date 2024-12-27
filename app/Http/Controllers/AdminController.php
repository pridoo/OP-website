<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function addBlog(){
        return view('admin.addBlog');
    }

    public function addPost(Request $request){
        $post=new Post;

        $post->title = $request->title;
        $post->content = $request->content;

        

        //upload image
        $image=$request->image;

        if($image){

        $imagename=time().'.'.$image->getClientOriginalExtension();
        $request->image->move('blogimage',$imagename);

        $post->image = $imagename;
        }
        

        $post->save();

        return redirect('showBlog')->with('message', 'Blog Added Successfully');
    }

    

    public function showBlog(){

        $post = Post::all();

        return view('admin.showBlog', compact('post'));
    }
   
    public function deleteBlog($id){
        $post = Post::find($id);

        $post->delete();

        return redirect()->back()->with('message', 'Blog Deleted Successfully');
    }

    public function editBlog($id){
        $post = Post::find($id);

        return view('admin.editBlog', compact('post'));
    }

    public function updateBLog(Request $request, $id){
        $post = Post::find($id);

        $post->title=$request->title;
        $post->content=$request->content;

        $oldImage = $post->image;

        $image=$request->image;

        if($image){
            $imagename=time().'.'.$image->getClientOriginalExtension();
            $request->image->move('blogimage',$imagename);

            $post->image = $imagename;

            if($oldImage){
                $oldImagePath = public_path('blogimage/'.$oldImage);
                if(file_exists($oldImagePath)){
                    unlink($oldImagePath);
                }
            }
        }

        $post->save();

        return redirect('showBlog')->with('message','Blog Updated Successfully');
    }

    
    
}
