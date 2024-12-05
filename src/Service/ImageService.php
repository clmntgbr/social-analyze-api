<?php

namespace App\Service;

use Ramsey\Uuid\Uuid;

class ImageService
{
    public function __construct(
        private readonly string $backUrl
    ) {}

    public function download(string $url, string $path): ?string
    {
        if (!is_dir(sprintf('public/%s', $path))) {
            mkdir(sprintf('public/%s', $path), 0755, true);
        }

        // Set a timeout to prevent hanging
        $context = stream_context_create([
            'http' => [
                'timeout' => 30
            ]
        ]);

        // Attempt to download the image
        $imageContent = file_get_contents($url, false, $context);

        if ($imageContent === false) {
            return null;
        }

        $path = sprintf('%s/%s.png', $path, Uuid::uuid4()->toString());

        if (file_put_contents(sprintf('public/%s', $path), $imageContent) === false) {
            return null;
        }

        return sprintf('%s/%s', $this->backUrl, $path);
    }
}