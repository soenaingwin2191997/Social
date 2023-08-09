@extends('layouts.master')

@section('content')
    <div class="col">
        @foreach ($posts as $post)
            <div id="parent" class="card shadow my-1">
                <div id="post">
                    <input type="hidden" value="{{ $post->id }}" id="postId">
                    <input type="hidden" value="{{ Auth::user()->id }}" id="userId">
                    <div class="col d-flex">
                        <div class="col d-flex p-2">
                            <div style="border-radius: 50%; border: 3px solid gray; width:60px; height:60px;"
                                class=" overflow-hidden">
                                <img style="object-fit: cover;" class="w-100 h-100"
                                    src="{{ asset('images/' . $post->profile_photo) }}" alt="">
                            </div>
                            <div class="p-2">
                                <span id="userName" class="fw-bold">{{ $post->name }}</span>
                            </div>
                        </div>
                        <div class="col-4 text-end p-3">
                            <span class="me-2">{{ $post->created_at->diffForHumans() }}</span>
                            <span><i class="fa-solid fa-ellipsis"></i></span>
                        </div>
                    </div>
                    <div class="p-2">
                        <p>{{ $post->text }}</p>
                    </div>
                    <div class="col p-2">
                        <img class="w-100 rounded" src="{{ asset('images/' . $post->photo) }}" alt="">
                    </div>
                </div>
                <div class="col ps-2">
                    @if (App\Models\Like::where('post_id', $post->id)->where('user_id', Auth::user()->id)->where('like', 1)->first())
                        <button type="button" postId={{ $post->id }} class="btn likeBtn text-danger"><i id="likeHeart"
                                class="fa-solid fa-heart fs-5"></i></button>
                    @else
                        <button type="button" postId={{ $post->id }} class="btn likeBtn"><i id="likeHeart"
                                class="fa-regular fa-heart fs-5"></i></button>
                    @endif

                    <button type="button" class="btn commentBtn" data-bs-toggle="modal" data-bs-target="#commentModal"><i
                            class="fa-regular fa-comment fs-5"></i></button>
                    <button type="button" class="btn"><i class="fa-solid fa-retweet fs-5"></i></button>
                    <button type="button" class="btn"><i class="fa-regular fa-paper-plane fs-5"></i></button>
                </div>
                <div class="ps-4 pb-2">
                    <span id="likeCount"
                        class="me-1">{{ App\Models\like::where('post_id', $post->id)->where('like', '1')->count() }}</span><span
                        class="me-3">Likes</span>
                    <a href="#">{{ $post->comments->count() }} replies</a>
                </div>
            </div>
        @endforeach
    </div>

    {{-- For Comment Modal --}}

    <div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">Modal title</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="commentModalBody">

                    </div>  
                </div>
                <div class="modal-footer">
                    <input type="text" class="form-control" id="comment" placeholder="Write Comments........">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="commentPostBtn" class="btn btn-primary">Post</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('socialJs')
    <script>
        $(document).ready(function() {
            $(".likeBtn").click(function() {
                $parent = $(this).parents("#parent");
                $post_id = $parent.find('#postId').val();
                $user_id = $parent.find('#userId').val();
                $likeCount = $parent.find('#likeCount').text();

                if ($(this).find('#likeHeart').hasClass('fa-regular')) {
                    $parent.find('#likeCount').html(Number($likeCount) + 1);
                } else {
                    $parent.find('#likeCount').html(Number($likeCount) - 1);
                }

                $(this).find('#likeHeart').toggleClass('fa-regular fa-solid');
                $(this).toggleClass('text-danger');

                $.ajax({
                    type: "get",
                    url: "{{ url('like/add') }}",
                    dataType: 'json',
                    data: {
                        'post_id': $post_id,
                        'user_id': $user_id,
                    },
                    success: function(res) {
                        console.log(res);
                    }
                });
            });

            $('.commentBtn').click(function() {
                $parent = $(this).parents('#parent');
                $userName = $parent.find('#userName').text();
                $post = $parent.find('#post').clone();

                $('#commentModalTitle').text($userName + "'s Post");
                $('#commentModalBody').html($post);

            });

            $('#commentPostBtn').click(function(){
                $parent=$(this).parents('#commentModal');
                $post_id = $parent.find('#postId').val();
                $user_id=$parent.find('#userId').val();
                $comment=$parent.find('#comment').val();

                if($comment!=""){
                    $.ajax({
                    type:'GET',
                    url:"{{ url('comment/add') }}",
                    dataType:'json',
                    data:{
                        'post_id':$post_id,
                        'user_id':$user_id,
                        'comment':$comment,
                    },
                    success:function(res){
                        $parent.find('#comment').val("");
                        console.log(res);
                    }
                 });

                }
            });
        });
    </script>
@endsection
