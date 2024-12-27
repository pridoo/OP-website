<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Like;

class CommentController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'content' => 'required|string|max:500',
        ]);
        
        $comment = new Comment();
        $comment->post_id = $request->post_id;
        $comment->user_id = auth()->id();
        $comment->content = $request->content;
        $comment->save();

        return response()->json(['message' => 'Comment added successfully'],200);
    }

    public function like(Request $request){
        $request->validate([
            'post_id' => 'required|exists:posts,id',
        ]);

        $like = Like::where('post_id', $request->post_id)
            ->where('user_id', auth()->id())
            ->first();

        if($like){
            $like->delete();
            return response()->json(['status' => 'unliked']);
        }else{
            Like::create([
                'post_id' => $request->post_id,
                'user_id' => auth()->id(),
            ]);
            return response()->json(['status' => 'liked']);
        }
    }


}
