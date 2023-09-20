<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use App\Models\Album;
use App\Models\Artist;
use App\Helpers\AudioUtils;
use App\Models\Song;

class AdminController extends Controller
{
    private $audioUtils;

    public function __construct(AudioUtils $audioUtils)
    {
        $this->audioUtils = $audioUtils;
    }

    public function dashboard()
    {   
        $artists = Artist::all();
        $albums = Album::all(); 

        return view('admin_dashboard', compact('artists', 'albums'));
    }

    public function createAlbum(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'artist_id' => 'required|exists:artists,id',
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric|min:0.00',
        ]);

        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();

        }

        if ($request->hasFile('cover_image')) {

            $imagePath = $request->file('cover_image')->store('public/img/album_covers');

            $album = new Album([
                'title' => $request->input('title'),
                'artist_id' => $request->input('artist_id'),
                'cover_image' => str_replace('public/', 'storage/', $imagePath),
                'price' => $request->input('price'),
            ]);

            $album->save();

            return redirect()->route('admin.dashboard')->with('success', 'Album created successfully');
        }

        return redirect()->back()->with('error', 'Failed to upload the album cover image');

    }

    public function createSong(Request $request)
    {   
        $filename = '';

        $artists = Artist::all();
        $albums = Album::all();

        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'artist_id' => 'required|exists:artists,id',
            'audio_file' => 'required|mimes:mp3,wav,ogg,flac',
            'duration' => 'nullable|numeric',
            'album_id' => 'required|exists:albums,id',
            'price' => 'required|numeric|min:0.00',
        ]);

        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();

        }

        if ($request->hasFile('audio_file')) {
            $file = $request->file('audio_file');
            $filename = time() . '_' . $file->getClientOriginalName();

            $file->storeAs('public/audio/songs/', $filename);

            $song = Song::create([
                'title' => $request->input('title'),
                'artist_id' => $request->input('artist_id'),
                'audio_file' => 'public/audio/songs/' . $filename,
                'duration' => $request->input('duration'),
                'album_id' => $request->input('album_id'),
                'price' => $request->input('price'),
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
        $validatedData = $request->validate([
            'title' => 'required|string',
            'duration' => 'nullable|numeric',

        ]);

        $song = Song::create($validatedData);

        return redirect()->route('admin.dashboard')->with('success', 'Song created successfully');

    }

    public function createArtist(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
        ]);


        $artist = Artist::create($validatedData);

        return redirect()->route('admin.dashboard')->with('success', 'Artist created successfully');

    }
}
