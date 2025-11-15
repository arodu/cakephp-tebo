<?php
declare(strict_types=1);

namespace TeBo\Dto\Message;

use TeBo\Dto\Message;

class Document extends Message
{
/**
 * @return array
 */
    private function getDocumentData(): array
    {
        return $this->get('document', []);
    }

        /**
         * @return string
         */
    public function getFileId(): string
    {
        return $this->getDocumentData()['file_id'] ?? '';
    }

    /**
     * @return string|null
     */
    public function getFileName(): ?string
    {
        return $this->getDocumentData()['file_name'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getMimeType(): ?string
    {
        return $this->getDocumentData()['mime_type'] ?? null;
    }

    /**
     * @param string $unit
     * @return integer|null
     */
    public function getFileSize(string $unit = 'bytes'): ?int
    {
        $sizeInBytes = $this->getDocumentData()['file_size'] ?? null;
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