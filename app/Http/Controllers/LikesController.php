<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class LikesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Post $post) {
        Cache::forget('count.likes' . $post->id);
        return auth()->user()->liking()->toggle($post);
    }
}
