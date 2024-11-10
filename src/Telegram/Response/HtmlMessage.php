<?php

declare(strict_types=1);

namespace TeBo\Telegram\Response;

use TeBo\TeBoPlugin;

class HtmlMessage extends TextMessage implements ResponseInterface
{
    /**
     * @inheritDoc
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->setConfig('options', ['parse_mode' => 'HTML']);
    }
}
