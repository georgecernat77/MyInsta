<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentLikesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(\App\Models\Comment $comment)
    {
        return auth()->user()->commentLiking()->toggle($comment);
    }

    public function getLikes($commentId)
    {
        $comment = Comment::find($commentId);
        if (!$comment) {
            return response()->json(['error' => 'Comment not found!']);
        }
        return $comment->likes->count();
    }

}
