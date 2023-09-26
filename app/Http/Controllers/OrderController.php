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
use ZipArchive;

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
            $orderItem = OrderItem::where('song_id', $song->id)->first();

            $this->authorize('downloadAccess', $orderItem->order);

            $filePath = storage_path('app/' . $song->audio_file);

            if (file_exists($filePath)) {
                $fileName = $song->title . '.mp3';

                header("Content-Type: application/octet-stream");
                header("Content-Disposition: attachment; filename=\"$fileName\"");
                header("Content-Length: " . filesize($filePath));
                readfile($filePath);

                exit;
            }
        }
        
        http_response_code(404);
    }

    public function downloadAlbum($albumId)
    {
        if (!class_exists('ZipArchive')) {
            return redirect()->back()->with('error', 'ZipArchive class is not available in this PHP environment.');
        }

        $album = Album::find($albumId);

        if (!$album) {
            return redirect()->back()->with('error', 'Album not found.');
        }

        $orderItem = OrderItem::where('album_id', $album->id)->first();

        if(!$orderItem) {
            return redirect()->back()->with('error', 'This album does not have an associated order.');
        }

        $this->authorize('downloadAccess', $orderItem->order);

        $tempDir = tempnam(sys_get_temp_dir(), 'album_');
        unlink($tempDir);
        mkdir($tempDir);

        $logData = [];

        foreach ($album->songs as $index => $song) {
            $originalFilePath = storage_path('app/' . $song->audio_file);
            $newFileName = "track{$index}.mp3";
            $newFilePath = "{$tempDir}/{$newFileName}";

            if (copy($originalFilePath, $newFilePath)) {
                $logData[] = "Copied song: {$originalFilePath} to {$newFilePath}";
            } else {
                $logData[] = "Failed to copy song: {$originalFilePath}";
            }
        }

        $zipFileName = $album->title . '.zip';
        $zipFilePath = "{$tempDir}/{$zipFileName}";
        $zip = new ZipArchive();

        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {

            foreach (glob("{$tempDir}/*.mp3") as $songFile) {
                $zip->addFile($songFile, basename($songFile));
            }

            $zip->close();

            header("Content-Type: application/zip");
            header("Content-Disposition: attachment; filename=\"$zipFileName\"");
            header("Content-Length: " . filesize($zipFilePath));

            readfile($zipFilePath);

            foreach (glob("{$tempDir}/*") as $file) {
                unlink($file);
            }
            rmdir($tempDir);

            exit;
        }

        return redirect()->back()->with('error', 'Failed to create zip archive.');
    }

}
