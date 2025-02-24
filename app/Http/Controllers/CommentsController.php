<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

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

        $post->comments()->create([
            'user_id' => auth()->user()->id,
            'content' => $data['content']
        ]);
        return redirect('/p/' . $post->id);
    }
    
}
