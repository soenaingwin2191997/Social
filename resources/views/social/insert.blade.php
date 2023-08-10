@extends('layouts.master')

@section('content')
    <div class="col">
        <div class="d-flex">
            <div class="col d-flex p-3">
                <div style="border-radius: 50%; border: 3px solid gray; width:60px;    height:60px;"
                    class=" overflow-hidden">
                    <img style="object-fit: cover;" class="w-100 h-100" src="{{ asset('storage/profile_photos/' .Auth::user()->profile_photo) }}"
                        alt="Photo">
                </div>
                <div class="ps-3 py-1">
                    <span id="userName" class="fw-bold">{{ Auth::user()->name }}</span>
                </div>
            </div>
        </div>
        <form action="{{ url('post/add') }}" method="post" enctype="multipart/form-data" class="col-12 p-2">
            @csrf
            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
            <div class="my-3">
                <input type="file" accept="image/jpg,image/jpeg,image/png" name="photo" class="form-control">
            </div>
            <div class="mb-3">
                <textarea name="caption" class="form-control"></textarea>
            </div>
            <div class="mb-3 text-end">
                <button class="btn btn-success">Post</button>
            </div>
        </form>
    </div>
@endsection
