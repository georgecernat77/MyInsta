<div class="modal-container container">
    <div class="post-div d-flex flex-row row align-items-stretch">
        <div class="col-8 p-0">
            <img src="/storage/{{ $post->image }}" class="w-100">
        </div>
        <div class="right-div col-4">

                <div class="d-flex align-items-center justify-content-between pt-3">
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
                                    <span class="text-dark">{{ $post->user->username }}</span>
                                </a>
                            </div>
                        </div>
                        @cannot('update', $post)
                            <div class="pl-3">
                                <follow-button user-id="{{ $post->user->id }}" follows="{{ $follows }}"
                                               is-link-style="{{ true }}"></follow-button>
                            </div>
                        @endcannot
                    </div>
                    @can('update', $post)
                        <button class="open-options-btn text-decoration-none" onclick="toggleOptions()">
                            <svg aria-label="More options" height="24"
                                 role="img" viewBox="0 0 24 24" width="24"><title>More options</title>
                                <circle cx="12" cy="12" r="1.5"></circle>
                                <circle cx="6" cy="12" r="1.5"></circle>
                                <circle cx="18" cy="12" r="1.5"></circle>
                            </svg>
                        </button>
                    @endcan
                </div>
                @can('update', $post)
                    <div id="options-modal" class="modal">
                        <div class="modal-content p-0">
                            <div class="modal-body p-0">
                                <div class="options-tab d-flex flex-column justify-content-center align-items-center">
                                    <div class="options-button-div pt-2">

                                        <button class="options-button delete-button btn" onclick="toggleDeletePost()">Delete</button>
                                    </div>
                                    <div class="options-button-div">
                                        <button class="options-button btn text-decoration-none" onclick="toggleEditPost()">Edit</button>
                                    </div>
                                    <div class="options-button-div pb-2">
                                        <button class="options-button btn" onclick="toggleOptions()">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan
                @can('update', $post)
                    <div id="edit-modal" class="modal">
                        <div class="modal-content p-0">
                            <div class="modal-header d-flex justify-content-between align-items-center">
                                <button class="modal-edit-button close-button btn text-decoration-none" onclick="toggleEditPost()">Cancel</button>
                                <h5 class="edit-title">Edit Caption</h5>
                                <button class="modal-edit-button done-button btn text-decoration-none" onclick="toggleEditPost()">Done</button>
                            </div>
                            <div class="modal-body p-0">
                                <div class="edit-tab p-3">
                                    <form action="#" id="edit-caption-form">
                                        <div class="d-flex flex-column justify-content-center align-items-center">
                                            {{--                                            <label for="caption-textarea" class="edit-label">Edit caption</label>--}}
                                            <p id="input-error"></p>
                                            <label for="caption-textarea" class="edit-label"></label>
                                            <textarea name="caption-textarea" class="w-100" id="caption-textarea" rows="5">{{$post->caption}}</textarea>
                                            <p id="charCount">0/250</p>
                                            <input type="hidden" name="post-id" id="post-id" value="{{ $post->id  }}">
                                            <button class="btn save-button" id="save-caption" type="submit" disabled>Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan
                @can('update', $post)
                    <div id="delete-modal" class="modal">
                        <div class="modal-content p-0">
                            <div class="modal-header pt-4 d-flex flex-column justify-content-between align-items-center">
                                <h5 class="detele-title">Delete Post?</h5>
                                <p class="delete-text">Are you sure you want to delete this post?</p>
                            </div>
                            <div class="modal-body p-0">
                                <div class="options-tab d-flex flex-column justify-content-center align-items-center">
                                    <div class="options-button-div pt-2">
                                        <button class="options-button delete-button btn" onclick="safeDeletePost()">Delete</button>
                                    </div>
                                    <div class="options-button-div pb-2">
                                        <button class="options-button btn" onclick="toggleDeletePost()">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan
                @can('update', $post)
                    <div id="succes-modal" class="modal">
                        <div class="modal-content p-0">
                            <div class="modal-body text-center p-5">
                                <span class="checkmark">&#10004;</span>
                                <p class="succes-message"></p>
                            </div>
                        </div>
                    </div>
                @endcan
                <hr>
                <div class="comments-and-caption index-comments-and-caption mb-1">
                    <div class="pfp-and-caption d-flex">
                        <div class="d-flex align-items-center">
                            <div class="pr-3">
                                <a class="text-decoration-none" href="/profile/{{ $post->user->id }}">
                                    <img src="{{ $post->user->profile->profileImage()}}" alt=""
                                         class="w-100 rounded-circle"
                                         style="max-width: 35px">
                                </a>
                            </div>
                            <div class="caption-and-date d-flex flex-column">
                                <div class="caption d-flex align-items-center">
                                    <span class="font-weight-bold">
                                    <a class="text-decoration-none" href="/profile/{{ $post->user->id }}">
                                        <span class="text-dark">{{ $post->user->username  }}</span>
                                    </a>
                                    </span>
                                    <div class="pl-1" id="post-caption">
                                        {{$post->caption}}
                                    </div>
                                </div>
                                <div class="caption-date mt-1"
                                     style="font-size: 12px; color: rgb(168,168,168,1); font-weight: 400">
                                    {{ \App\Helpers\DateHelper::formatTimeDifference($post->created_at) }}
                                </div>
                            </div>
                        </div>

                    </div>
                    <div id="comments-section" class="comments-section mt-4">
                        @foreach($postComments as $comment)
                            <div class="pfp-and-comment d-flex" style="position:relative">
                                <div class="pr-3">
                                    <a class="text-decoration-none" href="/profile/{{ $comment->user->id }}">
                                        <img src="{{ $comment->user->profile->profileImage()}}" alt=""
                                             class="w-100 rounded-circle"
                                             style="max-width: 35px">
                                    </a>
                                </div>
                                <div class="comment-and-like d-flex">
                                    <div class="comment-and-date d-flex flex-column mb-3">
                                        <div class="comment d-flex align-items-center">
                                            <span class="font-weight-bold">
                                            <a class="text-decoration-none" href="/profile/{{ $comment->user->id }}">
                                                <span class="text-dark">{{ $comment->user->username }}</span>
                                            </a>
                                            </span>
                                            <div class="pl-1">{{$comment->content}}</div>
                                        </div>
                                        <div class="comment-date mt-1 d-flex"
                                             style="font-size: 12px; color: rgb(168,168,168,1); font-weight: 400">
                                            {{ \App\Helpers\DateHelper::formatTimeDifference($comment->created_at) }}
                                            <div class="likes-count ml-3 font-weight-bold"
                                                 id="likes-count-{{ $comment->id }}">
                                                {{$comment->likesCount}} likes
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn comment-like-btn" onclick="likeComment({{ $comment->id }})">
                                        @if ($comment->commentLiking)
                                            <img :src="'/storage/icons/heart-full.png'" class='comment-like-icon'
                                                 id="like-icon-{{ $comment->id }}"/>
                                        @else
                                            <img :src="'/storage/icons/heart-empty.png'" class='comment-like-icon'
                                                 id="like-icon-{{ $comment->id }}"/>
                                        @endif
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <like-window post-id="{{ $post->id }}" likes-count="{{ $likesCount }}"
                             liking="{{ $liking }}"></like-window>
                <div class="add-comment-section">
                    <form action="#" id="add-comment-form">
                        @csrf
                        <div class="d-flex align-items-center" style="justify-content: space-between;">
                            <div class="form">
                                <textarea id="add-comment-content" name="content" class="no-outline" placeholder="Add a comment..."
                                          required></textarea>
                                <input type="hidden" name="post-id" id="post-id" value="{{ $post->id  }}">
                            </div>
                            <button type="submit" class="btn-link-as-text">Post</button>
                        </div>
                    </form>
                </div>

        </div>
    </div>
</div>

