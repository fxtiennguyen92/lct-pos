<?php

namespace App\Http\Controllers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UploadImage extends Controller
{
    public static function getDefaultAvatar($name)
    {
        $text = trim(collect(explode(' ', $name))->map(function ($segment) {
            return mb_substr($segment, 0, 1);
        })->join(' '));

        return 'https://ui-avatars.com/api/?name='.urlencode($text).'&color=fff&background=0087FA';
    }

    public static function updateImage($image, $storagePath = 'images', string $imageName, $previous = null)
    {
        // Delete previous image
        if ($previous) {
            Storage::delete($previous);
        }
        
        // Store the image in the public disk under the images folder
        $path = $image->storeAs($storagePath, $imageName, 'public');
        
        // Generate the full URL for the image
        return Storage::url($path);
    }

    public static function deleteImage($imagePath)
    {
        return Storage::delete($imagePath);
    }

    
}
