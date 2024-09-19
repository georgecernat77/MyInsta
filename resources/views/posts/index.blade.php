@extends('layouts.app')

@section('content')
    <div class="container d-flex flex-column align-items-center">
        @foreach($posts as $post)
            <div class="pt-2">
                <div class="row">
                    <div class="col-6 offset-3 pb-2">
                        <div class="d-flex align-items-center">
                            <div class="pr-3">
                                <img src="{{ $post->user->profile->profileImage()}}" alt="" class="w-100 rounded-circle"
                                     style="max-width: 40px">
                            </div>
                            <div>
                                <div class="font-weight-bold">
                                    <a class="text-decoration-none" href="/profile/{{ $post->user->id }}">
                                        <span class="text-dark">{{ $post->user->username }}</span>
                                    </a>
                                    <a class="text-decoration-none pl-2" href="#">
                                        Follow
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 offset-3">
                        <a href="/p/{{ $post->id}}">
                            <img src="/storage/{{ $post->image }}" class="w-100">
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 offset-3 pt-2">
                        <p>
                    <span class="font-weight-bold">
                        <a class="text-decoration-none" href="/profile/{{ $post->user->id }}">
                            <span class="text-dark">{{ $post->user->username }}</span>
                        </a>
                    </span>
                            {{$post->caption}}
                        </p>
                    </div>
                </div>
            </div>
            @if (!$loop->last)
                <div class="pt-2 row col-6 align-items-center justify-content-center">
                    <hr style="max-width: 100%">
                </div>
            @endif
        @endforeach
    </div>
    <div class="row">
        <div class="col-12 d-flex justify-content-center">
            {{$posts->links()}}
        </div>
    </div>
@endsection
