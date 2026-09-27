<?php
namespace App\Services;

use ImageKit\ImageKit;

class ImageKitService
{
    protected $imageKit;

    public function __construct()
    {
        $this->imageKit = new ImageKit(
            config('services.imagekit.public_key'),
            config('services.imagekit.private_key'),
            config('services.imagekit.url_endpoint')
        );
    }

    public function uploadImage($file, $folder = 'products')
    {
        $uploadFile = $this->imageKit->uploadFiles([
            'file' => fopen($file->getRealPath(), 'r'),
            'fileName' => time() . '_' . $file->getClientOriginalName(),
            'folder' => $folder,
            'useUniqueFileName' => true,
        ]);

        if (isset($uploadFile->result) && $uploadFile->result) {
            return $uploadFile->result->url;
        }

        return null;
    }
}