<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use function Pest\Laravel\json;

class CommentsController extends Controller
{
    public function store(\App\Models\Post $post)
    {
        $data = request()->validate([
            'content' => [
                'required',
                'max:100',
                'min:3'
            ]
        ]);

        $comment = $post->comments()->create([
            'user_id' => auth()->user()->id,
            'content' => $data['content']
        ]);
        if (request()->ajax()) {
            $profile_image = $comment->user->profile->profileImage();
            return response()->json([
                'message' => 'Comment Added!',
                'comment' => [
                    'id' => $comment->id,
                    'content' => $comment->content ,
                    'user' => [
                        'id' => $comment->user->id,
                        'username' => $comment->user->username,
                        'profileImage' => $profile_image,
                    ],
                ]
            ], 200);
        }
        else {
            return response()->json(['message' => 'Comment Added!'], 200);
        }

    }

}
