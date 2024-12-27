<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;

class HomeController extends Controller
{
    public function index()
    {
        $post = Post::all();
    
        if (Auth::check()) {
            $usertype = Auth::user()->role;
            if ($usertype == 'user') {
                return view('home.homepage', compact('post'));
            } elseif ($usertype == 'admin') {
                return view('admin.showBlog', compact('post'));
            }
        }
    
        return view('home.homepage', compact('post')); // For logged-out users
    }
    
    



    public function homepage()
    {
        $post = Post::all();  // Retrieve all posts
    
        return view('home.homepage', compact('post'));  // Pass posts to the view
    }
    

    public function blogContent($id)
    {
        $post = Post::findOrFail($id); // Use findOrFail to handle invalid ID
        return view('home.blogContent', compact('post'));
    }
    

    public function search(Request $request)
{
    $search = $request->input('search');
    $sort = $request->input('sort');  // Get sort option if provided

    // Perform search
    $query = Post::where('title', 'LIKE', "%{$search}%");

    // Apply sorting if sort parameter is present
    if ($sort === 'a-z') {
        $query->orderBy('title', 'asc');
    } elseif ($sort === 'z-a') {
        $query->orderBy('title', 'desc');
    } elseif ($sort === 'most-liked') {
        $query->withCount('likes')->orderBy('likes_count', 'desc');
    }

    // Get the results
    $posts = $query->get();

    return response()->json($posts);
}


    public function filter(Request $request){
        $sort = $request->input('sort');

        if ($sort === 'a-z') {
            $posts = Post::orderBy('title', 'asc')->get();
        } elseif ($sort === 'z-a') {
            $posts = Post::orderBy('title', 'desc')->get();
        } elseif ($sort === 'most-liked') {
            $posts = Post::withCount('likes')->orderBy('likes_count', 'desc')->get();
        } else {
            $posts = Post::all();
        }
    
        return response()->json($posts);
    }
}
