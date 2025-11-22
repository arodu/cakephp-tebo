<?php
declare(strict_types=1);

namespace TeBo\Dto\Message;

use TeBo\Dto\Message;

class Voice extends Message
{
    /**
     * @return array
     */
    private function getVoiceData(): array
    {
        return $this->get('voice', []);
    }

    /**
     * @return string
     */
    public function getFileId(): string
    {
        return $this->getVoiceData()['file_id'] ?? '';
    }

    /**
     * @return string
     */
    public function getFileUniqueId(): string
    {
        return $this->getVoiceData()['file_unique_id'] ?? '';
    }

    /**
     * @return string|null
     */
    public function getMimeType(): ?string
    {
        return $this->getVoiceData()['mime_type'] ?? null;
    }

    /**
     * @param string $unit
     * @return integer|null
     */
    public function getFileSize(string $unit = 'bytes'): ?int
    {
        $sizeInBytes = $this->getVoiceData()['file_size'] ?? null;
        if ($sizeInBytes === null) {
            return null;
        }

        return match (strtolower($unit)) {
            'kb' => (int) round($sizeInBytes / 1024),
            'mb' => (int) round($sizeInBytes / (1024 * 1024)),
            'gb' => (int) round($sizeInBytes / (1024 * 1024 * 1024)),
            default => $sizeInBytes,
        };
    }
}