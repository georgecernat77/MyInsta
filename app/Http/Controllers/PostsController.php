<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
        foreach ($posts as $post) {
            $post->follows = auth()->user() ? auth()->user()->following->contains($post->user->id) : false;
            $post->commentsCount = $post->comments->count();
            $post->liking = auth()->user() ? auth()->user()->liking->contains($post) : false;
            $post->likesCount = Cache::remember(
                'count.likes' . $post->id,
                now()->addSeconds(30),
                function () use ($post) {
                    return $post->likes->count();
                }
            );
//            dd($post->comments()->with(['user.profile', 'likes'])->get());
//            foreach ($post->postComments as $postComment)
//            {
//                $postComment->commentLiking = auth()->user() ? auth()->user()->commentLiking->contains($postComment) : false;
//                $postComment->likesCount = $postComment->likes->count();
//            }
        }


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
    public function show($id)
    {
        try {
            $post = Post::findOrFail($id);
        }catch (ModelNotFoundException $e) {
            return redirect('/')->with('error', 'Postarea nu a fost gasita!');
        }
        $liking = auth()->user() ? auth()->user()->liking->contains($post) : false;
        $follows = auth()->user() ? auth()->user()->following->contains($post->user->id) : false;
        $isAuthor = auth()->user()->id == $post->user->id;
        $likesCount = Cache::remember(
            'count.likes' . $post->id,
            now()->addSeconds(30),
            function () use ($post) {
                return $post->likes->count();
            }
        );
        $postComments = $post->comments()->with(['user.profile', 'likes'])->get();
        foreach ($postComments as $postComment)
        {
            $postComment->commentLiking = auth()->user() ? auth()->user()->commentLiking->contains($postComment) : false;
            $postComment->likesCount = $postComment->likes->count();
        }

//        dd($post->likes()->get());
        if(request()->ajax()) {
            return view('posts/_modal_content', [
                'post' => $post,
                'liking' => $liking,
                'likesCount' => $likesCount,
                'follows' => $follows,
                'postComments' => $postComments,
                'isAuthor' => $isAuthor,

            ])->render();
        }
        return view('posts/show', [
            'post' => $post,
            'liking' => $liking,
            'likesCount' => $likesCount,
            'follows' => $follows,
            'postComments' => $postComments,
            'isAuthor' => $isAuthor,

        ]);
    }

    public function update(Post $post) {
       $this->authorize('update', $post);

       $data = request()->validate([
           'caption' => 'required|max:250'
       ]);
       if ($data['caption'] == $post->caption) {
           return response()->json(['message' => 'Descrierile sunt la fel!'], 304);
       }
       $post->update(['caption' => $data['caption']]);
       return response()->json(['message' => 'Descriere actualizata cu succes!']);
   }

   public function destroy(Post $post) {
       $this->authorize('update', $post);
       $user_id = $post->user->id;
       $post->delete();
       return response()->json([
           'message' => 'Postare stearsa!',
           'reddirect_url' => route('profile.show', ['user' => $user_id])
       ]);

   }

    public function getLikes(Post $post)
    {
        $likes = $post->likes()->with('profile')->get();

        return response()->json($likes);
    }

}
