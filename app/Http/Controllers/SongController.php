<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\AudioUtils;
use App\Models\Song;

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
        $artists = Artist::all();

        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'artist_id' => 'required|exists:artists,id',
            'audio_file' => 'required|mimes:mp3,wav,ogg',
            'duration' => 'nullable|numeric',
            'album_id' => 'required|exists:albums,id',
            'price' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $duration = null;
        $audioPath = null;

        if ($request->hasFile('audio_file')) {
            $file = $request->file('audio_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('audio', $filename, 'public');

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

    public function destroy(Song $song)
    {

        $song->delete();

        return redirect()->route('albums.songs', $song->album)->with('success', 'Song deleted successfully');
    }
}
