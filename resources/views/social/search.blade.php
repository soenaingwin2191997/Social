@extends('layouts.master')

@section('content')
    <div class="col">
        <input type="hidden" id="senderId" value="{{ Auth::user()->id }}">
        @foreach ($users as $user)
            <div class="col d-flex">
                <div class="col d-flex p-2">
                    <div style="border-radius: 50%; border: 3px solid gray; width:60px;    height:60px;"
                        class=" overflow-hidden">
                        <img style="object-fit: cover;" class="w-100 h-100"
                            src="{{ asset('storage/profile_photos/'.$user->profile_photo) }}" alt="Photo">
                    </div>
                    <div class="ps-3 py-1">
                        <h5 class="h6 fw-bold" class="fw-bold">{{ $user->name }}</h5>
                        <h5 class="h6">24645 followers</h5>
                    </div>
                </div>
                <div class="col-4 text-end p-3">
                    <button type="button" receiverId="{{ $user->id }}" class="btn btn-info followAddBtn btn-sm px-3">Follow</button>
                </div>
            </div>
            <hr class="my-0 py-0">
        @endforeach
    </div>
@endsection

@section('socialJs')
    <script>
        $(document).ready(function(){
            $('.followAddBtn').click(function(){
                $receiverId=$(this).attr('receiverId');
                $senderId=$('#senderId').val();

                if($(this).text()=="Follow"){
                    $(this).text("Unfollow");
                    $.ajax({
                        type:'get',
                        url:"{{ url('follow') }}",
                        dataType:'json',
                        data:{
                            'sender_id':$senderId,
                            'receiver_id':$receiverId,
                        },
                        success:function(res){
                            console.log(res);
                        }
                    });
                }else{
                    $(this).text("Follow");
                    $.ajax({
                        type:'get',
                        url:"{{ url('unfollow') }}",
                        dataType:'json',
                        data:{
                            'sender_id':$senderId,
                            'receiver_id':$receiverId,
                        },
                        success:function(res){
                            console.log(res);
                        }
                    });
                }
            });
        });
    </script>
@endsection