<?php

declare(strict_types=1);

namespace TeBo\Utility\Trait;

trait RegisterListTrait
{
    protected array $list = [];

    /**
     * @return array
     */
    public function registerList(): array
    {
        return $this->list;
    }

    /**
     * @param mixed $item
     * @return void
     */
    public function registerItem(mixed $item): void
    {
        $this->list[] = $item;
    }

    /**
     * @param array $items
     * @return void
     */
    public function registerItems(array $items): void
    {
        foreach ($items as $item) {
            $this->addItem($item);
        }
    }

    /**
     * @return void
     */
    public function clearList(): void
    {
        $this->list = [];
    }
}
