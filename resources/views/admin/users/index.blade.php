@extends('admin.index')

@section('content')
    <h1>Users</h1>

    @if(Session::has('deleted_user'))
        <p class="bg-danger">{{session('deleted_user')}}</p>
    @endif

    <table class="table">
        <thead>
          <tr>
              <th>ID</th>
              <th>Photo</th>
              <th>Name</th>
              <th>Email</th>
              <th>Role</th>
              <th>Status</th>
              <th>Created</th>
              <th>Updated</th>
          </tr>
        </thead>
        <tbody>
          @if($users)
              @foreach($users as $user)
                  <tr>
                      <td>{{$user->id}}</td>
                      <td><img height="25" src="{{$user->photo ? ".." . $user->photo->path : "http://placehold.it/350x150"}}"/></td>
                      <td><a href="{{route('users.edit', $user->id)}}">{{$user->name}}</a></td>
                      <td>{{$user->email}}</td>
                      <td>{{$user->role ? $user->role->name : "User has no role"}}</td>
                      <td>{{$user->is_active == 1 ? 'Active' : 'Not Active'}}</td>
                      <td>{{$user->created_at->diffForHumans()}}</td>
                      <td>{{$user->updated_at->diffForHumans()}}</td>
                  </tr>
              @endforeach
          @endif
        </tbody>
      </table>

@endsection