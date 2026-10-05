<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Attaches an uploaded file to a model, keeping image dimensions for layout.
 */
class MediaUploader
{
    /**
     * @param  array<string, mixed>  $properties
     */
    public static function attach(HasMedia $model, UploadedFile $file, string $collection, array $properties = []): Media
    {
        $size = str_starts_with((string) $file->getMimeType(), 'image/') ? @getimagesize($file->getRealPath()) : false;

        if ($size) {
            $properties['width'] = $size[0];
            $properties['height'] = $size[1];
        }

        $extension = strtolower($file->guessExtension() ?: $file->getClientOriginalExtension());

        return $model->addMedia($file)
            ->usingName(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
            ->usingFileName(bin2hex(random_bytes(8)).'.'.$extension)
            ->withCustomProperties($properties)
            ->toMediaCollection($collection);
    }
}
