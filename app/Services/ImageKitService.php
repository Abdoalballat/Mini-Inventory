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

public function uploadImage($file)
{
    $imageKit = new \ImageKit\ImageKit(
        config('services.imagekit.public_key'),
        config('services.imagekit.private_key'),
        config('services.imagekit.url_endpoint')
    );

    $upload = $imageKit->uploadFiles([
        'file' => base64_encode(file_get_contents($file->getRealPath())),
        'fileName' => time() . '_' . $file->getClientOriginalName(),
        'folder' => 'products'
    ]);

    return $upload->result->url;
}
}