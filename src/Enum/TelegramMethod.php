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
    case DELETE_MESSAGE = 'deleteMessage';
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
    case SET_WEBHOOK = 'setWebhook';
    case DELETE_WEBHOOK = 'deleteWebhook';
    case GET_WEBHOOK_INFO = 'getWebhookInfo';
    case GET_ME = 'getMe';
    case GET_MY_COMMANDS = 'getMyCommands';
    case DELETE_MY_COMMANDS = 'deleteMyCommands';
    case EDIT_MESSAGE_TEXT = 'editMessageText';

    public function getMethod(): string
    {
        return $this->value;
    }
}
