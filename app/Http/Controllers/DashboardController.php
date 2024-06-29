<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;

class DashboardController extends Controller
{
    public function index()
    {
        $videos = Video::where('user_id', auth()->id())->get();
        return view('dashboard', compact('videos'));
    }
}