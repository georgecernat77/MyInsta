@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-8">
                <img src="/storage/{{ $post->image }}" class="w-100">
            </div>
            <div class="col-4">
                <div>
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

                <hr>

                <p>
                <span class="font-weight-bold">
                    <a class="text-decoration-none" href="/profile/{{ $post->user->id }}">
                        <span class="text-dark">{{ $post->user->username }}</span>
                    </a>
                </span>
                    {{$post->caption}}
                </p>
                <like-button post-id="{{ $post->id }}" liking="{{ $liking }}"></like-button>
{{--                <div class="d-flex font-weight-bold mt-3 ml-1">--}}
{{--                    {{ $likesCount }} likes--}}
{{--                </div>--}}
{{--                <div class="row">--}}
{{--                    @foreach($post->likes as $like)--}}
{{--                        <div class="d-flex align-items-center">--}}
{{--                            <div class="pr-3">--}}
{{--                                <a href="/profile/{{ $like->id }}">--}}
{{--                                    <img src="{{ $like->profile->profileImage()}}" alt="" class="w-100 rounded-circle"--}}
{{--                                         style="max-width: 40px">--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                            <div class="font-weight-bold">--}}
{{--                                <a class="text-decoration-none" href="/profile/{{ $like->id }}">--}}
{{--                                    <span class="text-dark">{{ $like->username }}</span>--}}
{{--                                </a>--}}
{{--                                <a class="text-decoration-none pl-2" href="#">--}}
{{--                                    Follow--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    @endforeach--}}
{{--                </div>--}}
                <like-window post-id="{{ $post->id }}" likes-count="{{ $likesCount }}"></like-window>
            </div>
        </div>
    </div>
@endsection
