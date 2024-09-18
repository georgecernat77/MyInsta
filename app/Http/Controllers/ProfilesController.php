<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ProfilesController extends Controller
{
    public function index(User $user)
    {
        $follows = (auth()->user()) ? auth()->user()->following->contains($user->id) : false;


        return view('profiles/index', [
            'user' => $user,
            'follows' => $follows,
        ]);
    }
    public function edit(User $user)
    {
        $this->authorize('update', $user->profile);

        return view('profiles/edit', [
            'user' => $user,
        ]);
    }
    public function update(User $user)
    {
        $this->authorize('update', $user->profile);

        $data = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'url' => 'url',
            'image' => '',
        ]);

        if(request('image')) {
            $imagePath = request('image')->store('profile', 'public');
            $manager = new ImageManager(new Driver());

            // read image from file system
            $image = $manager->read(public_path("storage/{$imagePath}"));
            $image->cover(1000, 1000);
            $image->save();
            $imageArr = ['image' => $imagePath];
        }

        auth()->user()->profile->update(array_merge(
            $data,
            $imageArr ?? []
        ));

        return redirect("/profile/{$user->id}");
    }
}
