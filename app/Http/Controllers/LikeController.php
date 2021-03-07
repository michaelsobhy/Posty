<?php

namespace App\Http\Controllers;

use App\Mail\PostLiked;
use App\Models\Post;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use function PHPUnit\Framework\isNull;

class LikeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function store(Post $post, Request $request)
    {
        if ($post->likedBy($request->user())) {
            return response(null, 409);
        }
        $deletedLike = Like::onlyTrashed()->where('user_id', $request->user()->id)->where('post_id', $post->id);
        if ($deletedLike->count() === 0) {
            $post->likes()->create([
                'user_id' => $request->user()->id
            ]);
        } else {
            $deletedLike->restore();
        }


//        if (!$post->likes()->onlyTrashed()->where('user_id', $request->user()->id)->count())
//        {
//            Mail::to($post->user)->send(new PostLiked(auth()->user(), $post));
//        }

        return back();
    }

    public function destroy(Post $post, Request $request)
    {
        $request->user()->likes()->where('post_id', $post->id)->delete();

        return back();
    }
}
