<?php

declare(strict_types=1);

namespace TeBo\Enum;

use Cake\Utility\Hash;

enum UpdateType: string
{
    case COMMAND = 'command';
    case MESSAGE = 'message';
    case EDITED_MESSAGE = 'edited_message';
    case CHANNEL_POST = 'channel_post';
    case EDITED_CHANNEL_POST = 'edited_channel_post';
    case INLINE_QUERY = 'inline_query';
    case CHOSEN_INLINE_RESULT = 'chosen_inline_result';
    case CALLBACK_QUERY = 'callback_query';
    case SHIPPING_QUERY = 'shipping_query';
    case PRE_CHECKOUT_QUERY = 'pre_checkout_query';
    case POLL = 'poll';
    case POLL_ANSWER = 'poll_answer';
    case REPLY = 'reply';

    public static function get(array $update): self
    {
        $type = Hash::get($update ?? [], 'message.entities.0.type');

        return match (true) {
            $type === 'bot_command' => self::COMMAND,
            isset($update['message']) => self::MESSAGE,
            isset($update['edited_message']) => self::EDITED_MESSAGE,
            isset($update['channel_post']) => self::CHANNEL_POST,
            isset($update['edited_channel_post']) => self::EDITED_CHANNEL_POST,
            isset($update['inline_query']) => self::INLINE_QUERY,
            isset($update['chosen_inline_result']) => self::CHOSEN_INLINE_RESULT,
            isset($update['callback_query']) => self::CALLBACK_QUERY,
            isset($update['shipping_query']) => self::SHIPPING_QUERY,
            isset($update['pre_checkout_query']) => self::PRE_CHECKOUT_QUERY,
            isset($update['poll']) => self::POLL,
            isset($update['poll_answer']) => self::POLL_ANSWER,
            isset($update['reply_to_message']) => self::REPLY,
            default => throw new \InvalidArgumentException('Invalid update data'),
        };
    }

    public function getChatPath(): string
    {
        return match ($this) {
            self::REPLY,
            self::MESSAGE,
            self::COMMAND => 'message.chat',
            self::EDITED_MESSAGE => 'edited_message.chat',
            self::CHANNEL_POST => 'channel_post.chat',
            self::EDITED_CHANNEL_POST => 'edited_channel_post.chat',
            self::INLINE_QUERY => 'inline_query.from',
            self::CHOSEN_INLINE_RESULT => 'chosen_inline_result.from',
            self::CALLBACK_QUERY => 'callback_query.message.chat',
            self::SHIPPING_QUERY => 'shipping_query.from',
            self::PRE_CHECKOUT_QUERY => 'pre_checkout_query.from',
            self::POLL => 'poll.from',
            self::POLL_ANSWER => 'poll_answer.user',
            default => throw new \InvalidArgumentException('Invalid update type'),
        };
    }

    public function getUserPath(): string
    {
        return match ($this) {
            self::REPLY,
            self::MESSAGE,
            self::COMMAND => 'message.from',
            self::EDITED_MESSAGE => 'edited_message.from',
            self::CHANNEL_POST => 'channel_post.from',
            self::EDITED_CHANNEL_POST => 'edited_channel_post.from',
            self::INLINE_QUERY => 'inline_query.from',
            self::CHOSEN_INLINE_RESULT => 'chosen_inline_result.from',
            self::CALLBACK_QUERY => 'callback_query.from',
            self::SHIPPING_QUERY => 'shipping_query.from',
            self::PRE_CHECKOUT_QUERY => 'pre_checkout_query.from',
            self::POLL => 'poll.from',
            self::POLL_ANSWER => 'poll_answer.user',
            default => throw new \InvalidArgumentException('Invalid update type'),
        };
    }

    public function getMessagePath(): string
    {
        return match ($this) {
            self::REPLY,
            self::MESSAGE,
            self::COMMAND => 'message',
            self::EDITED_MESSAGE => 'edited_message',
            self::CHANNEL_POST => 'channel_post',
            self::EDITED_CHANNEL_POST => 'edited_channel_post',
            self::INLINE_QUERY => 'inline_query',
            self::CHOSEN_INLINE_RESULT => 'chosen_inline_result',
            self::CALLBACK_QUERY => 'callback_query.message',
            self::SHIPPING_QUERY => 'shipping_query',
            self::PRE_CHECKOUT_QUERY => 'pre_checkout_query',
            self::POLL => 'poll',
            self::POLL_ANSWER => 'poll_answer',
            default => throw new \InvalidArgumentException('Invalid update type'),
        };
    }
}
