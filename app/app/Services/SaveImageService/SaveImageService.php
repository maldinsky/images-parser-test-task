<?php

namespace App\Services\SaveImageService;

use App\Services\SaveImageServiceInterface;
use GuzzleHttp\Psr7\Utils;
use Psr\Http\Message\StreamInterface;

class SaveImageService implements SaveImageServiceInterface
{
    private string $saveImagesDirectory;

    public function __construct(string $saveImagesDirectory)
    {
        $this->saveImagesDirectory = $saveImagesDirectory;
    }

    public function save(string $fileName): StreamInterface
    {
        $saveDirectory = $this->saveImagesDirectory . date('Y-m-d-H-i-s') . '/';

        if (!is_dir($saveDirectory)) {
            mkdir($saveDirectory, 0775, true);
        }

        $resource = Utils::tryFopen($saveDirectory . $fileName, 'w');

        return Utils::streamFor($resource);
    }
}