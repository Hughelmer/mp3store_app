<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

    public function downloadSong($songId)
     {
        $song = Song::find($songId);

        if ($song) {
            $filePath = storage_path('app/public/audio/songs/' . $song->audio_file);

            if (file_exists($filePath)) {
                $headers = [
                    'Content-Type' => 'audio/mpeg',
                    'Content-Disposition' => 'attachment; filename="' . $song->title . '.mp3"',
                ];

                return Response::stream(function () use ($filePath) {
                    readfile($filePath);
                }, 200, $headers);
            }
        }

        return redirect()->back()->with('error', 'Song not found.');
    }

    public function downloadAlbum($albumId)
    {
        $album = Album::find($albumId);

        if ($album) {
              
            $filePath = storage_path('app/' . $filePath);

            if (Storage::exists($filePath)) {
                return $this->downloadFile($filePath, $album->title . '.zip');
            }
        }

        return redirect()->back()->with('error', 'Album not found.');
    }

    private function downloadFile($filePath, $fileName)
    {
        return response()->download(
            storage_path('app/' . $filePath),
            $fileName,
            [
                'Content-Type' => 'application/octet-stream',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            ]
        );
    }

}
