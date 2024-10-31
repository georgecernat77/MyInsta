@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row align-items-stretch">
            <div class="col-8">
                <img src="/storage/{{ $post->image }}" class="w-100">
            </div>
            <div class="col-4">
                <div>
                    <div class="d-flex align-items-center">
                        <div class="pr-3">
                            <a class="text-decoration-none" href="/profile/{{ $post->user->id }}">
                                <img src="{{ $post->user->profile->profileImage()}}" alt="" class="w-100 rounded-circle"
                                     style="max-width: 35px">
                            </a>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="font-weight-bold">
                                <a class="text-decoration-none" href="/profile/{{ $post->user->id }}">
                                    <span class="text-dark">{{ $post->user->profile->title }}</span>
                                </a>
{{--                                <a class="text-decoration-none pl-2" href="#">--}}
{{--                                    Follow--}}
{{--                                </a>--}}
                            </div>
                            <div class="pl-3"><follow-button user-id="{{ $post->user->id }}" follows="{{ $follows }}" is-link-style="{{ true }}"></follow-button></div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="comments-and-caption mb-1">
                    <div class="pfp-and-caption d-flex">
                        <div class="d-flex align-items-center">
                            <div class="pr-3">
                                <a class="text-decoration-none" href="/profile/{{ $post->user->id }}">
                                    <img src="{{ $post->user->profile->profileImage()}}" alt="" class="w-100 rounded-circle"
                                         style="max-width: 35px">
                                </a>
                            </div>
                            <div class="caption-and-date d-flex flex-column">
                                <div class="caption d-flex align-items-center">
                                    <span class="font-weight-bold">
                                    <a class="text-decoration-none" href="/profile/{{ $post->user->id }}">
                                        <span class="text-dark">{{ $post->user->profile->title  }}</span>
                                    </a>
                                    </span>
                                    <div class="pl-1">
                                        {{$post->caption}}
                                    </div>
                                </div>
                                <div class="caption-date mt-1" style="font-size: 12px; color: rgb(168,168,168,1); font-weight: 400">
                                    {{ \App\Helpers\DateHelper::formatTimeDifference($post->created_at) }}
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="comments-section mt-3">
                        @foreach($postComments as $comment)
                            <div class="pfp-and-comment d-flex">
                                <div class="pr-3">
                                    <a class="text-decoration-none" href="/profile/{{ $comment->user->id }}">
                                        <img src="{{ $comment->user->profile->profileImage()}}" alt="" class="w-100 rounded-circle"
                                             style="max-width: 35px">
                                    </a>
                                </div>
                                <div class="comment-and-like d-flex">
                                    <div class="comment-and-date d-flex flex-column mb-3">
                                        <div class="comment d-flex align-items-center">
                                            <span class="font-weight-bold">
                                            <a class="text-decoration-none" href="/profile/{{ $comment->user->id }}">
                                                <span class="text-dark">{{ $comment->user->profile->title }}</span>
                                            </a>
                                            </span>
                                                <div class="pl-1">{{$comment->content}}</div>
                                        </div>
                                        <div class="comment-date mt-1 d-flex" style="font-size: 12px; color: rgb(168,168,168,1); font-weight: 400">
                                           {{ \App\Helpers\DateHelper::formatTimeDifference($comment->created_at) }}
                                           <div class="likes-count ml-3 font-weight-bold">
                                               {{$comment->likesCount}} likes
                                           </div>
                                        </div>
                                    </div>
                                    <commentlike-button comment-id="{{ $comment->id }}" liking="{{ $comment->commentLiking }}"></commentlike-button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <like-window post-id="{{ $post->id }}" likes-count="{{ $likesCount }}" liking="{{ $liking }}"></like-window>
                <div class="add-comment-section">
                    <form action="/comment/{{ $post->id }}" method="post">
                        @csrf
                        <div class="d-flex align-items-center" style="justify-content: space-between;">
                            <div class="form">
                                <textarea name="content" class="no-outline" placeholder="Add a comment..." required></textarea>
                            </div>
                            <button type="submit" class="btn-link-as-text">Post</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
