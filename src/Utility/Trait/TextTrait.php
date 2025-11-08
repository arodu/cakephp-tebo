<?php

declare(strict_types=1);

namespace TeBo\Utility\Trait;

trait TextTrait
{
    /**
     * The text of the message.
     *
     * @var array
     */
    protected array $text = [];

    /**
     * Resets the text property of the Message object.
     *
     * @return static
     */
    public function resetText(): static
    {
        $this->text = [];

        return $this;
    }

    /**
     * Adds text to the message.
     *
     * @param string|array|null $text The text to add. It can be a string or an array of strings.
     * @return static
     */
    public function addText(string|array|null $text = null): static
    {
        if (is_string($text)) {
            $this->text[] = $text;
        }

        if (is_array($text)) {
            $this->text = array_merge($this->text, $text);
        }

        return $this;
    }

    /**
     * Get the text of the message.
     *
     * @return string The text of the message.
     */
    public function getText(): string
    {
        return implode(PHP_EOL, $this->text);
    }
}
