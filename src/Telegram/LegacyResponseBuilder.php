<?php

declare(strict_types=1);

namespace TeBo\Telegram;

use TeBo\Enum\TelegramMethod;

/**
 * Class LegacyResponseBuilder for compatibility with older response builders.
 *
 * @deprecated use \TeBo\Telegram\Response::create() instead
 */
class LegacyResponseBuilder extends Response
{
    public function __construct(TelegramMethod|string $method)
    {
        parent::__construct($method);
    }

    public function addOptions(array $options): self
    {
        unset(
            $options['text'],
            $options['caption'],
            $options['photo'],
            $options['parse_mode'],
            $options['reply_markup'],
            $options['message_id'],
            $options['chat_id']
        );

        $this->data = array_merge($this->data, $options);
        return $this;
    }

    public function setRawInlineKeyboard(array $markup): self
    {
        $this->data['reply_markup'] = $markup;
        return $this;
    }

    public function setRawReplyKeyboard(array $markup): self
    {
        $this->data['reply_markup'] = $markup;
        return $this;
    }
}