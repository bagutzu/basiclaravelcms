@extends('admin.index')
@section('content')
    <h1>Posts</h1>

    @if(Session::has('deleted_post'))
        <p class="bg-danger">{{session('deleted_post')}}</p>
    @endif

    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Body</th>
            <th>Created by</th>
            <th>Category</th>
            <th>Photo</th>
            <th>Created at</th>
            <th>Updated at</th>
        </tr>
        </thead>
        <tbody>
        @if($posts)
            @foreach($posts as $post)
                <tr>
                    <td>{{$post->id}}</td>
                    <td><a href="{{route('posts.edit', $post->id)}}">{{$post->title}}</a></td>
                    <td>{{str_limit($post->body, 20)}}</td>
                    <td>{{$post->user->name}}</td>
                    <td>{{$post->category ? $post->category->name : "Not categorized"}}</td>
                    <td><img height="50" src="{{$post->photo ? asset($post->photo->path) : "http://placehold.it/200x200"}}" alt=""></td>
                    <td>{{$post->created_at->diffForHumans()}}</td>
                    <td>{{$post->updated_at->diffForHumans()}}</td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>


@endsection