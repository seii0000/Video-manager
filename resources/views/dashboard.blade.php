@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Your Videos</h2>
    @if($videos->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($videos as $video)
                    <tr>
                        <td>{{ $video->title }}</td>
                        <td>{{ $video->description }}</td>
                        <td>
                            <a href="{{ route('videos.show', $video->id) }}" class="btn btn-sm btn-info">View</a>
                            <a href="{{ route('videos.edit', $video->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('videos.destroy', $video->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>You haven't uploaded any videos yet.</p>
    @endif
    <a href="{{ route('videos.create') }}" class="btn btn-success">Upload New Video</a>
</div>
@endsection