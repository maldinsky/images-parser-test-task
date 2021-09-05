<?php

namespace App\Services;

use Psr\Http\Message\StreamInterface;

interface SaveImageServiceInterface
{
    public function save(string $fileName): StreamInterface;
}
