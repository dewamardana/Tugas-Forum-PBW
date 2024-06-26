<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function createPost(Request $request)
    {
        // Validasi input form
        $request->validate([
            'content' => 'required|string',
        ]);

        // Buat post baru
        $post = new Post();
        $post->user_id = auth()->user()->id; // Pastikan user sudah login
        $post->parent_id = $request->input('parent_id') == 0 ? null : $request->input('parent_id');
        $post->level = 0; // Sesuaikan level jika diperlukan
        $post->content = $request->input('content');
        $post->save();

        // Redirect atau kembali dengan pesan sukses
        return redirect('/home')->with('success', 'Post created successfully!');
    }

    public function createComment(Request $request, $postId)
    {
        $post = Post::find($postId);

        if ($post) {
            $comment = new Post();
            $comment->user_id = Auth::id();
            $comment->parent_id = $postId;  // Comment on a post
            $comment->level = 1;
            $comment->content = $request->input('content');
            $comment->save();

            return redirect('/home')->with('success', 'Comment created successfully!');
        }

        return response()->json(['message' => 'Post not found'], 404);
    }

    public function replyComment(Request $request, $commentId)
    {
        $comment = Post::find($commentId);

        if ($comment) {
            $reply = new Post();
            $reply->user_id = Auth::id();
            $reply->parent_id = $commentId;  // Reply to a comment
            $reply->level = 2;
            $reply->content = $request->input('content');
            $reply->save();

            return redirect('/home')->with('success', 'Reply Comment created successfully!');
        }

        return response()->json(['message' => 'Comment not found'], 404);
    }
}
