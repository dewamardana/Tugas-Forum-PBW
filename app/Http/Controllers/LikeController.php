<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
   public function likePost($postId)
    {
        $userId = Auth::id();

        // Pastikan post ada
        $postLike = Post::findOrFail($postId);

        // Periksa apakah user sudah menyukai post ini
        $alreadyLiked = Like::where('user_id', $userId)->where('post_id', $postId)->exists();

        if (!$alreadyLiked) {
            // Mulai transaksi untuk memastikan konsistensi data
                // Tambahkan like pada post
                $postLike->like += 1;
                $postLike->save();

                // Buat entry baru pada tabel likes
                $like = new Like();
                $like->user_id = $userId;
                $like->post_id = $postId;
                $like->save();

            return back()->with('Berhasil', 'Anda berhasil Menyukai Post ini');
        }

        return back()->with('Gagal', 'Anda sudah menyukai post ini');
    }
}
