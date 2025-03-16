@extends('layouts.app')

@section('content')
    <div class="container d-flex flex-column align-items-center">
        @foreach($posts as $post)
            <div class="pt-1">
                <div class="row">
                    <div class="col-6 offset-3 pb-2">
                        <div class="d-flex align-items-center">
                            <div class="pr-3">
                                <a class="text-decoration-none" href="/profile/{{ $post->user->id }}">
                                    <img src="{{ $post->user->profile->profileImage()}}" alt=""
                                         class="w-100 rounded-circle"
                                         style="max-width: 40px">
                                </a>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="font-weight-bold">
                                    <a class="text-decoration-none" href="/profile/{{ $post->user->id }}">
                                        <span class="text-dark">{{ $post->user->username }}</span>
                                    </a>
                                    {{--                                    <a class="text-decoration-none pl-2" href="#">--}}
                                    {{--                                        Follow--}}
                                    {{--                                    </a>--}}
                                </div>
                                <div class="pl-3">
                                    <follow-button user-id="{{ $post->user->id }}" follows="{{ $post->follows }}"
                                                   is-link-style="{{ true }}"></follow-button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 offset-3">
                        <a onclick="togglePostModal({{$post->id}})" class="image-link">
                            <img src="/storage/{{ $post->image }}" class="w-100">
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 offset-3 mt-1">
                        <like-window post-id="{{ $post->id }}" likes-count="{{ $post->likesCount }}"
                                     liking="{{ $post->liking }}"></like-window>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 offset-3 mt-1">
                        <p class="mb-0 mt-0">
                    <span class="font-weight-bold">
                        <a class="text-decoration-none" href="/profile/{{ $post->user->id }}">
                            <span class="text-dark">{{ $post->user->username }}</span>
                        </a>
                    </span>
                            {{$post->caption}}
                        </p>
                    </div>
                    <div class="col-6 offset-3">
                        <div class="comments mt-1 mb-1">
                            <div class="comments-section">
                                @if($post->commentsCount == 1)
                                    <a class="view-comments" onclick="togglePostModal({{$post->id}})">View {{$post->commentsCount}} comment</a>
                                @elseif($post->commentsCount > 0)
                                    <a class="view-comments" onclick="togglePostModal({{$post->id}})">View all {{$post->commentsCount}} comments</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 offset-3">
                        <div class="add-comment-section index-add-comment-section">
                            <form action="/comment/{{ $post->id }}" method="post">
                                @csrf
                                <div class="d-flex align-items-center" style="justify-content: space-between;">
                                    <div class="form">
                                <textarea name="content" class="no-outline" placeholder="Add a comment..."
                                          required></textarea>
                                    </div>
                                    <button type="submit" class="btn-link-as-text">Post</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @if (!$loop->last)
                <div class="pt-4 row col-6 align-items-center justify-content-center">
                    <hr style="max-width: 100%">
                </div>
            @endif
        @endforeach
    </div>
    <div id="postModal" class="modal">
        <div class="modal-content index-modal-content p-0">
            <div id="modal-body"></div>
        </div>
    </div>
    <div id="shareModal" class="modal">
        <div class="modal-content p-0">
            <div class="modal-body p-0">
                <div class="options-tab d-flex flex-column justify-content-center align-items-center">
                    <div class="options-button-div pt-2">
                        <button class="options-button copy-link-button btn">Copy link</button>
                    </div>
                    <div class="options-button-div pb-2">
                        <button class="options-button btn" onclick="closeShareModal()">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 d-flex justify-content-center">
            {{$posts->links()}}
        </div>
    </div>
@endsection


