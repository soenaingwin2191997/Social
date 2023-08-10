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
                                    src="{{ asset('storage/profile_photos/' . $post->profile_photo) }}" alt="">
                            </div>
                            <div class="px-2 py-1">
                                <h5 id="userName" class="fw-bold h6">{{ $post->name }}</h5>
                                <h5 class="h6">{{ $post->created_at->diffForHumans() }}</h5>
                            </div>
                        </div>
                        <div class="col-2 text-end p-3">
                            <span><i class="fa-solid fa-ellipsis"></i></span>
                        </div>
                    </div>
                    <div class="p-2">
                        <p>{{ $post->caption }}</p>
                    </div>
                    <div class="col p-2">
                        <img class="w-100 rounded" src="{{ asset('storage/post_photos/' . $post->photo) }}" alt="">
                    </div>
                </div>
                <div class="col ps-2">
                    @if (App\Models\Like::where('post_id', $post->id)->where('user_id', Auth::user()->id)->first())
                        <button type="button" postId={{ $post->id }} class="btn likeBtn text-danger"><i id="likeHeart"
                                class="fa-solid fa-heart fs-5"></i></button>
                    @else
                        <button type="button" postId={{ $post->id }} class="btn likeBtn"><i id="likeHeart"
                                class="fa-regular fa-heart fs-5"></i></button>
                    @endif

                    <button type="button" class="btn commentAddBtn" data-bs-toggle="modal" data-bs-target="#commentAddModal"><i
                            class="fa-regular fa-comment fs-5"></i></button>
                    <button type="button" class="btn"><i class="fa-regular fa-paper-plane fs-5"></i></button>
                </div>
                <div class="ps-4 pb-2">
                    <a href="#" class="likeModalBtn" data-bs-toggle="modal" data-bs-target="#likeModal">
                        <span id="likeCount" class="me-1">{{ $post->likes->count() }}</span><span
                            class="me-3">Likes</span>
                    </a>
                    <a href="#" class="commentModalBtn" data-bs-toggle="modal" data-bs-target="#commentShowModal">{{ $post->comments->count() }} replies</a>
                </div>
            </div>
        @endforeach
    </div>

    {{-- For Comment Add Modal --}}

    <div class="modal fade" id="commentAddModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5" id="commentAddModalTitle">Modal title</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="commentAddModalBody">

                    </div>
                </div>
                <div class="modal-footer">
                    <input type="text" class="form-control" id="commentAddInput" placeholder="Write Comments........"
                        autofocus>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="commentAddBtn" class="btn btn-primary">Post</button>
                </div>
            </div>
        </div>
    </div>

    {{-- For Like Modal --}}
    <div class="modal fade" id="likeModal" tabindex="-1" aria-labelledby="exampleModalLabel"    aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">Likes</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="modalLikeBody" class="modal-body">

                </div>
            </div>
        </div>
    </div>

    {{-- For Comment Show Modal --}}

    <div class="modal fade" id="commentShowModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5" id="commentModalTitle">Modal title</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="commentShowBody">

                    </div>
                    <div id="commentShowModalComment" class="my-2">
                        
                    </div>
                </div>
                {{-- <div class="modal-footer">
                    <input type="text" class="form-control" id="commentModalInput" placeholder="Write Comments........"
                        autofocus>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="commentPostBtn" class="btn btn-primary">Post</button>
                </div> --}}
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

            $('.commentAddBtn').click(function() {
                $parent = $(this).parents('#parent');
                $userName = $parent.find('#userName').text();
                $post = $parent.find('#post').clone();

                $('#commentAddModalTitle').text($userName + "'s Post");
                $('#commentAddModalBody').html($post);
                $('#commentAddInput').attr('placeholder', `Replay To ${$userName}`);

            });

            $('#commentAddBtn').click(function() {
                $parent = $(this).parents('#commentAddModal');
                $post_id = $parent.find('#postId').val();
                $user_id = $parent.find('#userId').val();
                $comment = $parent.find('#commentAddInput').val();

                if ($comment != "") {
                    $.ajax({
                        type: 'GET',
                        url: "{{ url('comment/add') }}",
                        dataType: 'json',
                        data: {
                            'post_id': $post_id,
                            'user_id': $user_id,
                            'comment': $comment,
                        },
                        success: function(res) {
                            $parent.find('#commentAddInput').val("");
                            console.log(res);
                        }
                    });

                }
            });

            $('.likeModalBtn').click(function() {
                $parent = $(this).parents("#parent");
                $post_id = $parent.find('#postId').val();

                $.ajax({
                    type: "get",
                    url: "{{ url('like/show') }}",
                    dataType: 'json',
                    data: {
                        'post_id': $post_id,
                    },
                    success: function(res) {
                        $like = '';
                        for ($i = 0; $i < res.length; $i++) {
                            $like += `
                            <div class="col d-flex">
                                <div class="col d-flex p-2">
                                    <div style="border-radius: 50%; border: 3px solid gray; width:60px;    height:60px;"
                                        class=" overflow-hidden">
                                        <img style="object-fit: cover;" class="w-100 h-100"
                                            src="{{ asset('storage/profile_photos/${res[$i][`profile_photo`]}') }}" alt="">
                                    </div>
                                    <div class="px-2 py-1">
                                        <span id="userName" class="fw-bold">${res[$i]['name']}</span>
                                    </div>
                                </div>
                                <div class="col-4 text-end p-3">
                                    <button type="button" class="btn btn-info followAddBtn btn-sm px-3">Follow</button>
                                </div>
                            </div>
                            `;
                        }

                        $('#modalLikeBody').html($like);
                    }
                });
            });

            $('.commentModalBtn').click(function() {
                $parent = $(this).parents('#parent');
                $post_id = $parent.find('#postId').val()
                $userName = $parent.find('#userName').text();
                $post = $parent.find('#post').clone();

                $('#commentModalTitle').text($userName + "'s Post");
                $('#commentShowBody').html($post);
                $('#commentModalInput').attr('placeholder', `Replay To ${$userName}`);

                $.ajax({
                    type:'get',
                    url:"{{ url('comment/show') }}",
                    dataType:'json',
                    data:{
                        'post_id':$post_id,
                    },
                    success:function(res){

                        $commentShow='';
                        for($i=0; $i<res.length; $i++){
                            const targetDate = new Date(res[$i]['created_at']);
                            $commentShow+=`
                                <div class="col d-flex">
                                    <div class="col d-flex p-2">
                                        <div style="border-radius: 50%; border: 3px solid gray; width:60px;    height:60px;"
                                            class=" overflow-hidden">
                                            <img style="object-fit: cover;" class="w-100 h-100"
                                                src="{{ asset('storage/profile_photos/${res[$i][`profile_photo`]}') }}" alt="Photo">
                                        </div>
                                        <div class="px-2 py-1">
                                            <h5 id="userName" class="fw-bold fs-6">${res[$i]['name']}</h5>
                                            <h5 class="fs-6">${$.timeago(targetDate)}</h5>
                                        </div>
                                    </div>  
                                    <div class="col-2 text-end p-3">
                                        <span><i class="fa-solid fa-ellipsis"></i></span>
                                    </div>
                                </div>
                                <div style="margin-left: 75px;">
                                    <p>${res[$i]['comment']}</p>
                                </div>
                                <hr>
                            `;
                        }
                        $('#commentShowModalComment').html($commentShow);

                    }
                })

            });

        });
    </script>
@endsection
