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

    public static function updateImage(UploadedFile $photo, $storagePath = 'images', $previous = null)
    {
        return $photo->storePublicly($storagePath, ['disk' => config('filesystems.default')]);

        if ($previous) {
            Storage::disk(config('filesystems.default'))->delete($previous);
        }
    }

    public static function deleteImage($imagePath)
    {
        return Storage::disk(config('filesystems.default'))->delete($imagePath);
    }

    
}
