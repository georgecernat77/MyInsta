@extends('layouts.app')

@section('content')
    <div class="container d-flex flex-column align-items-center">
        @foreach($posts as $post)
            <div class="pt-2" style="max-width: 90%">
                <div class="row">
                    <div class="col-8 offset-2 pb-2">
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
                    <div class="col-8 offset-2">
                        <img src="/storage/{{ $post->image }}" class="w-100">
                    </div>
                </div>
                <div class="row">
                    <div class="col-8 offset-2 pt-2">
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
                <div class="pt-2 row col-8 align-items-center justify-content-center">
                    <hr style="max-width: 89%">
                </div>
            @endif
        @endforeach
    </div>
@endsection
