<?php 

namespace App\Helpers;

use getID3;

class AudioUtils
{
    public function calculateDuration($audioPath)
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
}

 ?>