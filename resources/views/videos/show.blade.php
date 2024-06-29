@extends('layouts.content')
@section('main-content')
<div class="container">
    <h2>{{ $video->title }}</h2>
    <video width="100%" controls>
        <source src="{{ asset('storage/' . $video->file_path) }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <p>{{ $video->description }}</p>
    <a href="{{ route('videos.edit', $video) }}" class="btn btn-primary">Edit</a>
    <form action="{{ route('videos.destroy', $video) }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
    </form>
    <a href="{{ route('videos.index') }}" class="btn btn-secondary">Back to List</a>
</div>
@endsection