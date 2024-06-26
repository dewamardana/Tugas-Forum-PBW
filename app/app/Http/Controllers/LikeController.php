<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
   public function likePost($postId)
    {
        $like = new Like();
        $like->user_id = Auth::id();
        $like->post_id = $postId;
        $like->save();

        return redirect('/home')->with('success', 'Like successfully!');
    }
}
