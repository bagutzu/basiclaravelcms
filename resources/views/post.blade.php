@extends('layouts.blog-post')

@section('content')
    <!-- Blog Post -->

    <!-- Title -->
    <h1>{{$post->title}}</h1>

    <!-- Author -->
    <p class="lead">
        by <a href="#">{{$post->user->name}}</a>
    </p>

    <hr>

    <!-- Date/Time -->
    <p><span class="glyphicon glyphicon-time"></span> Post created {{$post->created_at->diffForHumans()}}</p>

    <hr>

    <!-- Preview Image -->
    <img class="img-responsive" src="{{asset($post->photo->path)}}" alt="">

    <hr>

    <!-- Post Content -->
    <p>{{$post->body}}</p>
    <hr>

    <!-- Blog Comments -->

    @if(Auth::check())

        <!-- Comments Form -->
        <div class="well">
            @if(Session::has('comment_message'))
                {{session('comment_message')}}
            @endif
            <h4>Leave a Comment:</h4>
                {!! Form::open(['method' => 'POST', 'action' => 'PostCommentsController@store']) !!}

                    <input type="hidden" name="post_id" value="{{$post->id}}">

                    <div class="form-group">
                        {!! Form::label('body', 'Leave a comment') !!}
                        {!! Form::textarea('body', null, ['class' => 'form-control', 'rows' => 3]) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::submit('Submit comment', ['class' => 'btn btn-primary']) !!}
                    </div>

                {!! Form::close() !!}
        </div>

    @endif

    <hr>



    <!-- Posted Comments -->

    @if(count($comments) > 0)
        @foreach($comments as $comment)
            <!-- Comment -->
            <div class="media">
                <a class="pull-left" href="#">
                    <img height="50px" class="media-object" src="{{asset($comment->photo->path)}}" alt="">
                </a>
                <div class="media-body">
                    <h4 class="media-heading">{{$comment->author}}
                        <small>{{$comment->created_at->diffForHumans()}}</small>
                    </h4>
                    <p>{{$comment->body}}</p>

                    @if(count($comment->replies) > 0)
                        @foreach($comment->replies as $reply)
                            @if($reply->is_active == 1)
                                <!-- Nested Comment -->
                                <div class="media">
                                    <a class="pull-left" href="#">
                                        <img height="50" class="media-object" src="{{asset($reply->photo->path)}}" alt="">
                                    </a>
                                    <div class="media-body">
                                        <h4 class="media-heading">{{$reply->author}}
                                            <small>{{$reply->created_at->diffForHumans()}}</small>
                                        </h4>
                                        <p>{{$reply->body}}</p>

                                    </div>
                                </div>
                                <!-- End Nested Comment -->
                            @endif
                        @endforeach
                    @endif
                    <div class="comment-reply-container">
                        <button class="toggle-reply btn btn-primary pull-right">Reply</button>
                        <div class="comment-reply">
                            {!! Form::open(['method' => 'POST', 'action' => 'CommentRepliesController@createReply']) !!}

                            <input name="comment_id" type="hidden" value="{{$comment->id}}">

                            <div class="form-group">
                                {!! Form::label('body', 'Reply:') !!}
                                {!! Form::textarea('body', null, ['class' => 'form-control', 'rows' => 2]) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::submit('Leave reply', ['class' => 'btn btn-primary']) !!}
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

@endsection
