<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Song;

//for calculating audio duration
use App\Helpers\AudioUtils;
use Illuminate\Support\Facades\Validator;

class SongController extends Controller
{

    private $audioUtils;

    public function __construct(AudioUtils $audioUtils)
    {
        $this->audioUtils = $audioUtils;
    }

    public function index()
    {
        $songs = Song::all();
        return view('songs', compact('songs'));
    }

    public function show($id)
    {
        $song = Song::findOrFail($id);
        return view('songs.show', compact('song'));
    }

    public function viewSong(Song $song)
    {
        return view('song', compact('song'));
    }

    public function createSong(Request $request)
    {   
        // Fetch the list of artists from your database
        $artists = Artist::all();

        // Validate input
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'artist_id' => 'required|exists:artists,id',
            'audio_file' => 'required|mimes:mp3,wav,ogg',
            'duration' => 'nullable|numeric',
            'album_id' => 'required|exists:albums,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Initialize duration with a default value
        $duration = null;
        $audioPath = null;

        // Handle audio file upload
        if ($request->hasFile('audio_file')) {
            $file = $request->file('audio_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('audio', $filename, 'public');

            // Calculate the audio duration using the AudioUtils helper
            $audioPath = storage_path('app/public/audio/') . $filename;
            $duration = $this->audioUtils->calculateDuration($audioPath); 

        }

        $song = Song::create([
            'title' => $request->input('title'),
            'artist_id' => $request->input('artist_id'),
            'audio_file' => $audioPath ? 'public/audio/' . $filename : null,
            'duration' => $duration,
            'album_id' => $request->input('album_id'),
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Song uploaded successfully');
    }

    // Add methods for create, store, edit, update, and destroy here
}
