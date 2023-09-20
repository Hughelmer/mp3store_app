<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Requests\CreateAlbumRequest;
use App\Http\Requests\CreateArtistRequest;
use App\Http\Requests\CreateSongRequest;
use App\Http\Requests\CreateStoreSongRequest;
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

    public function createAlbum(CreateAlbumRequest $request)
    {

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

    public function createSong(CreateSongRequest $request)
    {   
        $filename = '';
        $artists = Artist::all();
        $albums = Album::all();

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


    public function storeSong(CreateStoreSongRequest $request)
    {
        $song = Song::create($request->validated());

        return redirect()->route('admin.dashboard')->with('success', 'Song created successfully');
    }

    public function createArtist(CreateArtistRequest $request)
    {
        $artist = Artist::create($request->validated());

        return redirect()->route('admin.dashboard')->with('success', 'Artist created successfully');
    }
}
