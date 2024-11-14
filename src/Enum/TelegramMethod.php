<?php
declare(strict_types=1);

namespace TeBo\Enum;

enum TelegramMethod: string
{
    case GET_UPDATES = 'getUpdates';
    case SEND_MESSAGE = 'sendMessage';
    case FORWARD_MESSAGE = 'forwardMessage';
    case SEND_PHOTO = 'sendPhoto';
    case SEND_AUDIO = 'sendAudio';
    case SEND_DOCUMENT = 'sendDocument';
    case SEND_VIDEO = 'sendVideo';
    case SEND_ANIMATION = 'sendAnimation';
    case SEND_VOICE = 'sendVoice';
    case SEND_VIDEO_NOTE = 'sendVideoNote';
    case SEND_MEDIA_GROUP = 'sendMediaGroup';
    case SEND_LOCATION = 'sendLocation';
    case EDIT_MESSAGE_LIVE_LOCATION = 'editMessageLiveLocation';
    case STOP_MESSAGE_LIVE_LOCATION = 'stopMessageLiveLocation';
    case SEND_VENUE = 'sendVenue';
    case SEND_CONTACT = 'sendContact';
    case SEND_POLL = 'sendPoll';
    case SEND_DICE = 'sendDice';
    case SEND_CHAT_ACTION = 'sendChatAction';
    case GET_USER_PROFILE_PHOTOS = 'getUserProfilePhotos';
    case GET_FILE = 'getFile';
    case KICK_CHAT_MEMBER = 'kickChatMember';
    case UNBAN_CHAT_MEMBER = 'unbanChatMember';
    case RESTRICT_CHAT_MEMBER = 'restrictChatMember';
    case PROMOTE_CHAT_MEMBER = 'promoteChatMember';
    case SET_CHAT_ADMINISTRATOR_CUSTOM_TITLE = 'setChatAdministratorCustomTitle';
    case SET_CHAT_PERMISSIONS = 'setChatPermissions';
    case EXPORT_CHAT_INVITE_LINK = 'exportChatInviteLink';
    case SET_CHAT_PHOTO = 'setChatPhoto';
    case DELETE_CHAT_PHOTO = 'deleteChatPhoto';
    case SET_CHAT_TITLE = 'setChatTitle';
    case SET_CHAT_DESCRIPTION = 'setChatDescription';
    case PIN_CHAT_MESSAGE = 'pinChatMessage';
    case UNPIN_CHAT_MESSAGE = 'unpinChatMessage';
    case UNPIN_ALL_CHAT_MESSAGES = 'unpinAllChatMessages';
    case LEAVE_CHAT = 'leaveChat';
    case GET_CHAT = 'getChat';
    case GET_CHAT_ADMINISTRATORS = 'getChatAdministrators';
    case GET_CHAT_MEMBERS_COUNT = 'getChatMembersCount';
    case GET_CHAT_MEMBER = 'getChatMember';
    case SET_CHAT_STICKER_SET = 'setChatStickerSet';
    case DELETE_CHAT_STICKER_SET = 'deleteChatStickerSet';
    case ANSWER_CALLBACK_QUERY = 'answerCallbackQuery';
    case SET_MY_COMMANDS = 'setMyCommands';
    case EDIT_MESSAGE_REPLY_MARKUP = 'editMessageReplyMarkup';

    public function getMethod(): string
    {
        return $this->value;
    }

    public function getDefaultOptions(): array
    {
        return match ($this) {
            self::GET_UPDATES => [
                'offset' => 0,
                'limit' => 100,
                'timeout' => 0,
                'allowed_updates' => [],
            ],
            self::SEND_MESSAGE => [
                'chat_id' => '',
                'text' => '',
                'parse_mode' => 'HTML',
                'entities' => [],
                'disable_web_page_preview' => false,
                'disable_notification' => false,
                'reply_to_message_id' => 0,
                'allow_sending_without_reply' => false,
                'reply_markup' => [],
            ],
            self::FORWARD_MESSAGE => [
                'chat_id' => '',
                'from_chat_id' => '',
                'message_id' => 0,
                'disable_notification' => false,
            ],
            self::SEND_PHOTO => [
                'chat_id' => '',
                'photo' => '',
                'caption' => '',
                'parse_mode' => 'HTML',
                'caption_entities' => [],
                'disable_notification' => false,
                'reply_to_message_id' => 0,
                'allow_sending_without_reply' => false,
                'reply_markup' => [],
            ],
            self::SEND_AUDIO => [
                'chat_id' => '',
                'audio' => '',
                'caption' => '',
                'parse_mode' => 'HTML',
                'caption_entities' => [],
                'duration' => 0,
                'performer' => '',
                'title' => '',
                'thumb' => '',
                'disable_notification' => false,
                'reply_to_message_id' => 0,
                'allow_sending_without_reply' => false,
                'reply_markup' => [],
            ],
            self::SEND_DOCUMENT => [
                'chat_id' => '',
                'document' => '',
                'thumb' => '',
                'caption' => '',
                'parse_mode' => 'HTML',
                'caption_entities' => [],
                'disable_content_type_detection' => false,
                'disable_notification' => false,
                'reply_to_message_id' => 0,
                'allow_sending_without_reply' => false,
                'reply_markup' => [],
            ],
            self::SEND_VIDEO => [
                'chat_id' => '',
                'video' => '',
                'duration' => 0,
                'width' => 0,
                'height' => 0,
                'thumb' => '',
                'caption' => '',
                'parse_mode' => 'HTML',
                'caption_entities' => [],
                'supports_streaming' => false,
                'disable_notification' => false,
                'reply_to_message_id' => 0,
                'allow_sending_without_reply' => false,
                'reply_markup' => [],
            ],
            self::SEND_ANIMATION => [
                'chat_id' => '',
                'animation' => '',
                'duration' => 0,
                'width' => 0,
                'height' => 0,
                'thumb' => '',
                'caption' => '',
                'parse_mode' => 'HTML',
                'caption_entities' => [],
                'supports_streaming' => false,
                'disable_notification' => false,
                'reply_to_message_id' => 0,
                'allow_sending_without_reply' => false,
                'reply_markup' => [],
            ],
            self::SEND_VOICE => [
                'chat_id' => '',
                'voice' => '',
                'caption' => '',
                'parse_mode' => 'HTML',
                'caption_entities' => [],
                'duration' => 0,
                'disable_notification' => false,
                'reply_to_message_id' => 0,
                'allow_sending_without_reply' => false,
                'reply_markup' => [],
            ],
            self::SEND_VIDEO_NOTE => [
                'chat_id' => '',
                'video_note' => '',
                'duration' => 0,
                'length' => 0,
                'thumb' => '',
                'disable_notification' => false,
                'reply_to_message_id' => 0,
                'allow_sending_without_reply' => false,
                'reply_markup' => [],
            ],
            self::SEND_MEDIA_GROUP => [
                'chat_id' => '',
                'media' => [],
                'disable_notification' => false,
                'reply_to_message_id' => 0,
                'allow_sending_without_reply' => false,
            ],
            self::SEND_LOCATION => [
                'chat_id' => '',
                'latitude' => 0.0,
                'longitude' => 0.0,
                'live_period' => 0,
                'heading' => 0,
                'proximity_alert_radius' => 0,
                'disable_notification' => false,
                'reply_to_message_id' => 0,
                'allow_sending_without_reply' => false,
                'reply_markup' => [],
            ],
            self::EDIT_MESSAGE_LIVE_LOCATION => [
                'chat_id' => '',
                'message_id' => 0,
                'inline_message_id' => '',
                'latitude' => 0.0,
                'longitude' => 0.0,
                'horizontal_accuracy' => 0.0,
                'heading' => 0,
                'proximity_alert_radius' => 0,
                'reply_markup' => [],
            ],
            self::STOP_MESSAGE_LIVE_LOCATION => [
                'chat_id' => '',
                'message_id' => 0,
                'inline_message_id' => '',
                'reply_markup' => [],
            ],
            self::SEND_VENUE => [
                'chat_id' => '',
                'latitude' => 0.0,
                'longitude' => 0.0,
                'title' => '',
                'address' => '',
                'foursquare_id' => '',
                'foursquare_type' => '',
                'google_place_id' => '',
                'google_place_type' => '',
                'disable_notification' => false,
                'reply_to_message_id' => 0,
                'allow_sending_without_reply' => false,
                'reply_markup' => [],
            ],
            self::SEND_CONTACT => [
                'chat_id' => '',
                'phone_number' => '',
                'first_name' => '',
                'last_name' => '',
                'vcard' => '',
                'disable_notification' => false,
                'reply_to_message_id' => 0,
                'allow_sending_without_reply' => false,
                'reply_markup' => [],
            ],
        };
    }

    public function getOptionsKeys(): array
    {
        return array_keys($this->getOptions());
    }
}