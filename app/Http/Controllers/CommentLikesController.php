<?php

namespace App\Http\Controllers;

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

}
