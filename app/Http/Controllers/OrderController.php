<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

use App\Models\Album;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Song;
use App\Models\User;

class OrderController extends Controller
{

    public function index()
    {
        $orders = Order::where('user_id', auth()->id())->get();
        return view('orders.index', compact('orders'));
    }

    public function show($id)
    {       
        $order = Order::findOrFail($id);
        return view('orders.show', compact('order'));
    }

    public function downloadSong(Response $response, $songId)
    {
        $song = Song::find($songId);

        if ($song) {
            $filePath = storage_path('app/public/audio/songs/' . $song->audio_file);

            if (file_exists($filePath)) {
                $fileName = $song->title . '.mp3';

                return response()->download($filePath, $fileName, [
                    'Content-Type' => 'audio/mpeg',
                    'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
                ]);
            }
        }

        return redirect()->back()->with('error', 'Song not found.');
    }

    public function downloadAlbum($albumId)
    {
        $album = Album::find($albumId);

        if ($album) {
            $filePath = storage_path('app/public/albums/' . $album->file_path); // Update the file path here

            if (file_exists($filePath)) {
                $fileName = $album->title . '.zip';

                return response()->download($filePath, $fileName, [
                    'Content-Type' => 'application/octet-stream',
                    'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
                ]);
            }
        }

        return redirect()->back()->with('error', 'Album not found.');
    }

}
