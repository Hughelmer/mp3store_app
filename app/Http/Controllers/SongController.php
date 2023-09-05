<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Song;

//for calculating audio duration
use getID3;
use getID3_writetags;

class SongController extends Controller
{
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
        dd($request->all()); // Check the data received in the request

        // Validate input
        $validatedData = $request->validate([
            'title' => 'required|string',
            'audio_file' => 'required|mimes:mp3,wav,ogg',
            'artist_id' => 'required|exists:artists,id',
            'duration' => 'nullable|numeric',
        ]);

        // Handle audio file upload
        if ($request->hasFile('audio_file')) {
            $file = $request->file('audio_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('audio', $filename, 'public');

            // Calculate the audio duration using a library like getID3 or FFmpeg
            $audioPath = storage_path('app/public/audio/') . $filename;
            $duration = $this->calculateDuration($audioPath); // Implement this function

            $song = Song::create([
                'title' => $validatedData['title'],
                'artist_id' => $validatedData['artist_id'],
                'audio_file' => 'public/audio/' . $filename,
                'duration' => $duration,
            ]);

            return redirect()->route('admin.dashboard')->with('success', 'Song uploaded successfully');
        }

        return redirect()->back()->with('error', 'Failed to upload the song');
    }

    /**
     * Calculate the audio duration using getID3 library.
     *
     * @param string $audioPath
     * @return float|null
     */
    private function calculateDuration($audioPath)
    {
        $getID3 = new getID3();
        $fileInfo = $getID3->analyze($audioPath);
        
        // Check if the audio duration is available in the file info
        if (isset($fileInfo['playtime_seconds'])) {
            return $fileInfo['playtime_seconds'];
        }
        
        // If duration is not available, return null or a default value
        return null;
    }

    // Add methods for create, store, edit, update, and destroy as needed
}
