<?php
declare(strict_types=1);

namespace TeBo\Dto\Message;

use TeBo\Dto\Message;

class Photo extends Message
{
    /**
     * @return array
     */
    public function getPhotoSizes(): array
    {
        return $this->get('photo', []);
    }

    /**
     * @return array|null
     */
    public function getBestPhoto(): ?array
    {
        $sizes = $this->getPhotoSizes();
        if (empty($sizes)) {
            return null;
        }

        usort($sizes, function (array $a, array $b) {
            $sizeA = $a['file_size'] ?? $a['width'] ?? 0;
            $sizeB = $b['file_size'] ?? $b['width'] ?? 0;
            return $sizeB <=> $sizeA;
        });

        return $sizes[0];
    }

    /**
     * @return string|null
     */
    public function getBestPhotoFileId(): ?string
    {
        $bestPhoto = $this->getBestPhoto();
        return $bestPhoto['file_id'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getCaption(): ?string
    {
        return $this->get('caption') ?? null;
    }
}