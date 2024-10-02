<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class PostsController extends Controller
{
   public function __construct()
   {
        $this->middleware('auth')->except('show');
   }

    public function index()
    {
        $users = auth()->user()->following()->pluck('profiles.user_id');
        $posts = Post::whereIn('user_id', $users)->with('user')->orderBy('created_at', 'DESC')->paginate(5);

        return view('posts/index', [
            'posts' => $posts,
        ]);
    }

    public function create()
    {
        return view('posts/create');
    }
    public function store()
    {
        $data = request()->validate([
          'caption' => 'required',
          'image' => ['required','image'],
        ]);

        $imagePath = request('image')->store('uploads', 'public');
        $manager = new ImageManager(new Driver());

        // read image from file system
        $image = $manager->read(public_path("storage/{$imagePath}"));
        $image->cover(1200, 1200);
        $image->save();

        auth()->user()->posts()->create([
            'caption' => $data['caption'],
            'image' => $imagePath,

        ]);

        return redirect('/profile/' . auth()->user()->id);
    }
    public function show(\App\Models\Post $post)
    {
        $liking = auth()->user() ? auth()->user()->liking->contains($post) : false;

        $likesCount = Cache::remember(
            'count.likes' . $post->id,
            now()->addSeconds(30),
            function () use ($post) {
                return $post->likes->count();
            }
        );

//        dd($post->likes()->get());
        return view('posts/show', [
            'post' => $post,
            'liking' => $liking,
            'likesCount' => $likesCount,

        ]);
    }

    public function getLikes(Post $post)
    {
        $likes = $post->likes()->with('profile')->get();

        return response()->json($likes);
    }

}
