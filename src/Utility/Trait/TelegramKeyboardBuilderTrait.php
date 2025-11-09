<?php

declare(strict_types=1);

namespace TeBo\Utility\Trait;

trait TelegramKeyboardBuilderTrait
{
    protected function row(array ...$buttons): array
    {
        return $buttons;
    }

    protected function button(string $text, string $callback_data): array
    {
        return ['text' => $text, 'callback_data' => $callback_data];
    }
    
    protected function buttonUrl(string $text, string $url): array
    {
        return ['text' => $text, 'url' => $url];
    }
}
