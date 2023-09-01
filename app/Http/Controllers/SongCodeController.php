<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SongCode;

class SongCodeController extends Controller
{
    public function index()
    {
        $songCodes = SongCode::all();
        return view('song_codes.index', compact('songCodes'));
    }

    public function show($id)
    {
        $songCode = SongCode::findOrFail($id);
        return view('song_codes.show', compact('songCode'));
    }

    // Add methods for create, store, edit, update, and destroy as needed
}
