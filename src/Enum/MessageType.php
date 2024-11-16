<?php

declare(strict_types=1);

namespace TeBo\Enum;

use Cake\Utility\Hash;

enum MessageType: string
{
    case TEXT = 'text';
    case PHOTO = 'photo';
    case AUDIO = 'audio';
    case DOCUMENT = 'document';
    case VIDEO = 'video';
    case ANIMATION = 'animation';
    case VOICE = 'voice';
    case VIDEO_NOTE = 'video_note';
    case CONTACT = 'contact';
    case LOCATION = 'location';
    case VENUE = 'venue';
    case POLL = 'poll';
    case DICE = 'dice';
    case STICKER = 'sticker';
    case LINK = 'link';
    case COMMAND = 'command';

    public const GROUP_TEXT = 'text';
    public const GROUP_MEDIA = 'media';
    public const GROUP_FILE = 'file';
    public const GROUP_LOCATION = 'location';
    public const GROUP_POLL = 'poll';
    public const GROUP_CONTACT = 'contact';
    public const GROUP_COMMAND = 'command';

    public static function getFromMessage(?array $message): self
    {
        $type = Hash::get($message ?? [], 'entities.0.type');
        return match (true) {
            $type === 'bot_command' => self::COMMAND,
            $type === 'url' => self::LINK,
            isset($message['photo']) => self::PHOTO,
            isset($message['audio']) => self::AUDIO,
            isset($message['document']) => self::DOCUMENT,
            isset($message['video']) => self::VIDEO,
            isset($message['animation']) => self::ANIMATION,
            isset($message['voice']) => self::VOICE,
            isset($message['video_note']) => self::VIDEO_NOTE,
            isset($message['contact']) => self::CONTACT,
            isset($message['location']) => self::LOCATION,
            isset($message['venue']) => self::VENUE,
            isset($message['poll']) => self::POLL,
            isset($message['dice']) => self::DICE,
            isset($message['sticker']) => self::STICKER,
            isset($message['reply_to_message']['text']) => self::TEXT,
            default => self::TEXT,
        };
    }

    public function is(string $type): bool
    {
        return match ($type) {
            self::GROUP_COMMAND => $this === self::COMMAND,
            self::GROUP_CONTACT => $this === self::CONTACT,
            self::GROUP_TEXT => in_array($this, [
                self::TEXT,
                self::LINK,
                self::COMMAND,
            ]),
            self::GROUP_MEDIA => in_array($this, [
                self::PHOTO,
                self::AUDIO,
                self::DOCUMENT,
                self::VIDEO,
                self::ANIMATION,
                self::VOICE,
                self::VIDEO_NOTE,
                self::STICKER,
            ]),
            self::GROUP_FILE => in_array($this, [
                self::AUDIO,
                self::DOCUMENT,
                self::VIDEO,
                self::ANIMATION,
                self::VOICE,
                self::VIDEO_NOTE,
            ]),
            self::GROUP_LOCATION => in_array($this, [
                self::LOCATION,
                self::VENUE,
            ]),
            self::GROUP_POLL => in_array($this, [
                self::POLL,
                self::DICE,
            ]),
            default => false,
        };
    }
}
