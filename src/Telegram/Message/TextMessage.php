<?php
declare(strict_types=1);

namespace TeBo\Telegram\Message;

use Cake\Core\InstanceConfigTrait;

class TextMessage implements MessageInterface
{
    protected array $text = [];

    public function __construct($text)
    {
        $this->text[] = $text;
    }

    public function resetText(?string $text = null): void
    {
        $this->text = [];
    }

    public function addText(string $text): void
    {
        $this->text[] = $text;
    }

    public function getText(): string
    {
        return implode("\n", $this->text);
    }
}
