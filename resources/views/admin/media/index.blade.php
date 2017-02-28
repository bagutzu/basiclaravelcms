@extends('admin.index')
@section('content')

    @if($photos)
        <table class="table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Created date:</th>
              </tr>
            </thead>
            <tbody>
            @foreach($photos as $photo)
                  <tr>
                    <td>{{$photo->id}}</td>
                    <td><img height="50" src="{{asset($photo->path)}}" alt=""></td>
                    <td>{{$photo->created_at ? $photo->created_at->diffForHumans() : "No date"}}</td>
                      <td>
                          {!! Form::open(['method' => 'DELETE', 'action' => ['MediaController@destroy', $photo->id]]) !!}
                            <div class="form-group">
                                {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                            </div>
                          {!! Form::close() !!}
                      </td>
                  </tr>
            @endforeach
            </tbody>
          </table>
    @endif
@endsection