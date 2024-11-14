<?php

declare(strict_types=1);

namespace TeBo\Utility\Trait;

use Cake\Utility\Hash;

trait DataManageTrait
{
    protected array $originalData = [];

    /**
     * @return array
     */
    public function getOriginalData(): array
    {
        return $this->originalData;
    }

    /**
     * @param array $originalData
     * @return void
     */
    public function setOriginalData(array $originalData): void
    {
        $this->originalData = $originalData;
    }

    /**
     * @param string $path
     * @param mixed $default
     * @return mixed
     */
    public function get(string $path, mixed $default = null): mixed
    {
        return Hash::get($this->getOriginalData(), $path, $default);
    }
}
