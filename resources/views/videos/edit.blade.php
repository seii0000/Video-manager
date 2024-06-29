@extends('layouts.content')
@section('main-content')
<div class="container">
    <h2>Edit Video</h2>
    <form action="{{ route('videos.update', $video) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $video->title }}" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description">{{ $video->description }}</textarea>
        </div>
        <div class="form-group">
            <label for="video">Replace Video File (optional)</label>
            <input type="file" class="form-control-file" id="video" name="video" accept="video/*">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('videos.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection