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
