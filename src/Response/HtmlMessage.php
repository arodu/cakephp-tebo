<?php

declare(strict_types=1);

namespace TeBo\Response;

use TeBo\Enum\TelegramMethod;
use TeBo\Response\LegacyResponseBuilder;

/**
 * @deprecated Esta clase está obsoleta. 
 * Usar ResponseBuilder::newMessage() en su lugar.
 */
class HtmlMessage extends TextMessage implements ResponseInterface
{
    public function __construct(string|array|null $text = null, array $options = [])
    {
        $this->addText($text);

        $this->builder = LegacyResponseBuilder::newMessage((string)$this->getText());

        if (isset($options['reply_markup'])) {
            $this->builder->setRawReplyKeyboard($options['reply_markup']);
        }
        $this->builder->addOptions($options);
    }
}