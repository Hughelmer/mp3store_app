<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;
use App\Models\Song;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin_dashboard');
    }

    public function createAlbum(Request $request)
    {
        // Validate input
        $validatedData = $request->validate([
            'title' => 'required|string',
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Create album
        $album = Album::create($validatedData);

        return redirect()->route('admin.dashboard')->with('success', 'Album created successfully');
    }

    public function createSong(Request $request)
    {
        // Validate input
        $validatedData = $request->validate([
            'title' => 'required|string',
            'duration' => 'nullable|numeric', // Make the duration field optional
            // Add more validation rules as needed
        ]);

        // Create song
        $song = Song::create($validatedData);

        return redirect()->route('admin.dashboard')->with('success', 'Song created successfully');
    }

    public function storeSong(Request $request)
    {
        // Validate input for song creation
        $validatedData = $request->validate([
            'title' => 'required|string',
            'duration' => 'nullable|numeric', // Make the duration field optional
            // Add more validation rules as needed
        ]);

        // Create song
        $song = Song::create($validatedData);

        return redirect()->route('admin.dashboard')->with('success', 'Song created successfully');
    }
}
