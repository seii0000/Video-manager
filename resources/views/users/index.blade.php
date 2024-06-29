@extends('layouts.content')
@section('main-content')
<div class="container">
    <h2>Users List</h2>
    <a href="{{ route('user.create') }}" class="btn btn-primary mb-3">Add New User</a>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Photo</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @if($user->photo)
                        <img src="{{ asset('storage/'.$user->photo) }}" alt="{{ $user->name }}" style="width: 50px; height: 50px; object-fit: cover;">
                    @else
                        No Photo
                    @endif
                </td>
                <td>
                    <a href="{{ route('user.edit', $user->id) }}" class="btn btn-sm btn-primary">Edit</a>
                    <form action="{{ route('user.delete') }}" method="POST" style="display:inline;">
                        @csrf
                        <input type="hidden" name="id" value="{{ $user->id }}">
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection