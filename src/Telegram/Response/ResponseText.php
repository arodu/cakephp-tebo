<?php
declare(strict_types=1);

namespace TeBo\Telegram\Response;

use Cake\Core\InstanceConfigTrait;

class ResponseText implements ResponseInterface
{
    protected array $text = [];

    public function __construct($text = '')
    {
        if (is_array($text)) {
            $this->text = $text;
        } else {
            $this->text[] = $text;
        }
    }

    public function resetText(): void
    {
        $this->text = [];
    }

    public function addText(string|array $text): void
    {
        if (is_string($text)) {
            $this->text[] = $text;

            return;
        }

        $this->text = array_merge($this->text, $text);
    }

    public function addImage(string $url): void
    {
        // @todo
    }

    public function getText(): string
    {
        return implode("\n", $this->text);
    }
}
