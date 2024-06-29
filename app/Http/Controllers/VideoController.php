<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::where('user_id', auth()->id())->get();
        return view('videos.index', compact('videos'));
    }

    public function create()
    {
        return view('videos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video' => 'required|file|mimetypes:video/mp4,video/avi,video/mpeg,video/quicktime|max:102400', // 100MB limit
        ]);

        try {
            if ($request->hasFile('video')) {
                $video = $request->file('video');
                $filePath = $video->store('videos', 'public');
                
                $newVideo = Video::create([
                    'user_id' => auth()->id(), // Assuming you're using authentication
                    'title' => $request->title,
                    'description' => $request->description,
                    'file_path' => $filePath,
                ]);

                return redirect()->route('videos.index')->with('success', 'Video uploaded successfully.');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error uploading video: ' . $e->getMessage());
        }

        return back()->with('error', 'No video file uploaded.');
    }

    // Implement other methods (show, edit, update, destroy) similarly
    public function show(Video $video)
    {
        if ($video->user_id !== Auth::id()) {
            abort(403);
        }
        return view('videos.show', compact('video'));
    }

    public function edit(Video $video)
    {
        if ($video->user_id !== Auth::id()) {
            abort(403);
        }
        return view('videos.edit', compact('video'));
    }

    public function update(Request $request, Video $video)
    {
        if ($video->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required',
            'video' => 'sometimes|mimes:mp4,mov,ogg,qt|max:20000',
        ]);

        $video->title = $request->title;
        $video->description = $request->description;

        if ($request->hasFile('video')) {
            Storage::disk('public')->delete($video->file_path);
            $file = $request->file('video');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('videos', $fileName, 'public');
            $video->file_path = $filePath;
        }

        $video->save();

        return redirect()->route('videos.index')->with('success', 'Video updated successfully');
    }

    public function destroy(Video $video)
    {
        if ($video->user_id !== Auth::id()) {
            abort(403);
        }

        Storage::disk('public')->delete($video->file_path);
        $video->delete();

        return redirect()->route('videos.index')->with('success', 'Video deleted successfully');
    }
}