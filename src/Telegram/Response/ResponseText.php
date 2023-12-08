<?php
declare(strict_types=1);

namespace TeBo\Telegram\Response;

use Cake\Core\InstanceConfigTrait;
use Cake\Http\Client\Response;

class ResponseText implements ResponseInterface
{
    protected array $text = [];

    public function __construct(string|array $text = '')
    {
        $this->addText($text);
    }

    public function resetText(): ResponseText
    {
        $this->text = [];

        return $this;
    }

    public function addText(string|array $text): ResponseText
    {
        if (is_string($text)) {
            $this->text[] = $text;
        }

        if (is_array($text)) {
            $this->text = array_merge($this->text, $text);
        }

        return $this;
    }

    public function addImage(string $url): ResponseText
    {
        // @todo

        return $this;
    }

    public function getText(): string
    {
        return implode("\n", $this->text);
    }
}
