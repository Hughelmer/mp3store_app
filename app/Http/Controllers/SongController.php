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

    public function destroy(Song $song)
    {

        $song->delete();

        return redirect()->route('albums.songs', $song->album)->with('success', 'Song deleted successfully');
    }
}
