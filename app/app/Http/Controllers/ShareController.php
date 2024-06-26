<?php

namespace App\Http\Controllers;

use App\Models\Share;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShareController extends Controller
{
    public function sharePost($postId)
    {
        $share = new Share();
        $share->user_id = Auth::id();
        $share->post_id = $postId;
        $share->save();

        return redirect('/home')->with('success', 'Shared successfully!');
    }
}
