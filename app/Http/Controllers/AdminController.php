<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;
use App\Models\Song;
use App\Models\Artist;
use App\Helpers\AudioUtils;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{

    private $audioUtils;

    public function __construct(AudioUtils $audioUtils)
    {
        $this->audioUtils = $audioUtils;
    }

    public function dashboard()
    {   
        $artists = Artist::all(); // Retrieve all artists from the database

        return view('admin_dashboard', compact('artists')); // Pass the artists variable to the view
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
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'artist_id' => 'required|exists:artists,id',
            'audio_file' => 'required|mimes:mp3,wav,ogg',
            'duration' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Handle audio file upload
        if ($request->hasFile('audio_file')) {
            $file = $request->file('audio_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('audio', $filename, 'public');

            $song = Song::create([
                'title' => $request->input('title'),
                'artist_id' => $request->input('artist_id'),
                'audio_file' => 'public/audio/' . $filename,
                'duration' => $request->input('duration'),
            ]);

            if ($song) {
                return redirect()->route('admin.dashboard')->with('success', 'Song uploaded successfully');
            } else {
                return redirect()->back()->with('error', 'Failed to save the song');
            }
        }

        return redirect()->back()->with('error', 'Failed to upload the song');
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

    public function createArtist(Request $request)
    {
        // Validate input
        $validatedData = $request->validate([
            'name' => 'required|string',
        ]);

        // Create artist
        $artist = Artist::create($validatedData);

        return redirect()->route('admin.dashboard')->with('success', 'Artist created successfully');
    }

}
