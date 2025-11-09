<?php
declare(strict_types=1);

namespace TeBo\Utility\Trait;

use TeBo\Response\Response;
use TeBo\Response\ResponseInterface;

/**
 * Trait para construir objetos Response de Telegram.
 * Debe usarse en clases que tienen acceso a un objeto Chat
 * o que pueden retornar el Response directamente.
 */
trait ResponseBuilderTrait
{
    /**
     * @param string|array $html
     * @return ResponseInterface
     */
    public function buildHtml(string|array $html): ResponseInterface
    {
        return Response::newMessage($html)->asHtml();
    }

    /**
     * @param string|array $text
     * @return ResponseInterface
     */
    public function buildText(string|array $text): ResponseInterface
    {
        return Response::newMessage($text)->asHtml(false);
    }
    
    /**
     * @param int $messageId El ID del mensaje a editar.
     * @param string|array $text
     * @return ResponseInterface
     */
    public function buildEditMessage(int $messageId, string|array $text): ResponseInterface
    {
        return Response::editMessage($messageId)->text($text);
    }

    /**
     * @param int $messageId El ID del mensaje a editar.
     * @param array $keyboardRows El nuevo teclado.
     * @return ResponseInterface
     */
    public function buildEditKeyboard(int $messageId, array $keyboardRows): ResponseInterface
    {
        return Response::editKeyboard($messageId)
            ->setInlineKeyboard($keyboardRows);
    }

    /**
     * Construye un Response para una acción de chat (typing, upload_photo, etc.).
     *
     * @param string $action La acción de chat.
     * @return ResponseInterface
     */
    public function buildChatAction(string $action): ResponseInterface
    {
        return Response::chatAction($action);
    }
}