<?php
declare(strict_types=1);

namespace TeBo\Telegram\Enum;

enum UpdateType: string
{
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

    public static function get(array $data): self
    {
        if (isset($data['message'])) {
            return self::MESSAGE;
        } elseif (isset($data['edited_message'])) {
            return self::EDITED_MESSAGE;
        } elseif (isset($data['channel_post'])) {
            return self::CHANNEL_POST;
        } elseif (isset($data['edited_channel_post'])) {
            return self::EDITED_CHANNEL_POST;
        } elseif (isset($data['inline_query'])) {
            return self::INLINE_QUERY;
        } elseif (isset($data['chosen_inline_result'])) {
            return self::CHOSEN_INLINE_RESULT;
        } elseif (isset($data['callback_query'])) {
            return self::CALLBACK_QUERY;
        } elseif (isset($data['shipping_query'])) {
            return self::SHIPPING_QUERY;
        } elseif (isset($data['pre_checkout_query'])) {
            return self::PRE_CHECKOUT_QUERY;
        } elseif (isset($data['poll'])) {
            return self::POLL;
        } elseif (isset($data['poll_answer'])) {
            return self::POLL_ANSWER;
        }

        throw new \InvalidArgumentException('Invalid update data');
    }

    public function getChatPath(): string
    {
        return match ($this) {
            self::MESSAGE => 'message.chat',
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

    public function getMessagePath(): string
    {
        return match ($this) {
            self::MESSAGE => 'message',
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