@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-3 p-5">
            <img src="https://i.ibb.co/3zyWTPs/profile-picture.jpg" class="rounded-circle" style="width: 150px; height: 150px;">
        </div>
        <div class="col-9 pt-5" style="padding-left: 6rem">
            <div class="d-flex justify-content-between align-items-baseline">
                <h2>{{$user->username}}</h2>
                <a href="/p/create" class="text-decoration-none">Add New Post</a>
            </div>
            <a href="/profile/{{ $user->id }}/edit" class="text-decoration-none">Edit Profile</a>
            <div class="d-flex">
                <div class="pr-5"><strong>{{$user->posts->count()}}</strong> posts</div>
                <div class="pr-5"><strong>239k</strong> followers</div>
                <div class="pr-5"><strong>177</strong> following</div>
            </div>
            <div class="pt-3 font-weight-bold">
                {{ $user->profile->title }}
            </div>
            <div>{{ $user->profile->description }} </div>
            <div><a href="#" class="text-decoration-none">{{$user->profile->url}}</a></div>
        </div>
    </div>
    <div class="row pt-5  d-flex flex-row" >
            @foreach($user->posts as $post)
            <div class="col-4 pb-4">
                <a href="/p/{{$post->id}}">
                    <img src="/storage/{{ $post->image }}" alt="" class="w-100 mr-4">
                </a>
            </div>
            @endforeach
    </div>
</div>
@endsection
