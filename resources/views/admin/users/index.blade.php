@extends('layouts/admin')



@section('content')

    @if(Session::has('deleted_user'))

        <p class="bg-danger">{{session('deleted_user')}}</pclass>

        @endif

    <h1>Users</h1>

    <table class="table">
        <thead>
        <tr>
            <th>Id</th>
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
<?php // var_dump($user); ?>
        <tr>
            <td>{{$user->id}}</td>
            <td><img height="40" width="40" src="{{$user->photo ? $user->photo->file : 'http://placehold.it/40x40'}}" alt=""></td>
            <td><a href="{{route('admin.users.edit', $user->id)}}"> {{$user->name}}</a></td>
            <td>{{$user->email}}</td>
            <td>{{$user->role ? $user->role->name : 'User has no role'}}</td>
            <td>{{$user->is_active == 1 ? 'Active' : 'Not Active' }}</td>
            <td>{{$user->created_at->diffForHumans()}}</td>
            <td>{{$user->updated_at->diffForHumans()}}</td>
        </tr>


            @endforeach

        @endif

        </tbody>
    </table>





@stop