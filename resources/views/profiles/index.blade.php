@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-3 p-5">
            <img src="{{ $user->profile->profileImage()}}" class="rounded-circle w-100">
        </div>
        <div class="col-9 pt-4" style="padding-left: 3rem">
            <div class="d-flex justify-content-between align-items-baseline">
                <div class="d-flex align-items-center pb-2">
                    <div class="h4">{{$user->username}}</div>
                    @cannot('update', $user->profile)
                        <follow-button user-id="{{ $user->id }}" follows="{{ $follows }}"></follow-button>
                    @endcannot
                </div>
                @can('update', $user->profile)
                    <a href="/p/create" class="text-decoration-none">Add New Post</a>
                @endcan
            </div>
            @can('update', $user->profile)
                <a href="/profile/{{ $user->id }}/edit" class="text-decoration-none">Edit Profile</a>
            @endcan
            <div class="d-flex">
                <div class="pr-5"><strong>{{ $postCount }}</strong> posts</div>
                <div class="pr-5"><strong>{{ $followersCount }}</strong> followers</div>
                <div class="pr-5"><strong>{{ $followingCount }}</strong> following</div>
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
            <div class="col-4 pb-4 single-profile-post">
                <a href="/p/{{$post->id}}">
                    <div class="post-image">
                        <img src="/storage/{{ $post->image }}" alt="" class="w-100">
                        <div class="overlay"></div>
                    </div>
                </a>
            </div>
            @endforeach
    </div>
</div>
@endsection
