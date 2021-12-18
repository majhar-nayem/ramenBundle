<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait Upload
{
    public static function uploadFile(UploadedFile $uploadedFile, $folder = null, $disk = 'public', $filename = null)
    {
        $name = !is_null($filename) ? $filename : Str::random(64);

        return $uploadedFile->storeAs($folder, $name.'.'.$uploadedFile->getClientOriginalExtension(), $disk);
    }

    public static function deleteFile($filename = null, $folder = null,  $disk = 'public')
    {
        Storage::disk($disk)->delete($folder.$filename);
    }
}
