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
        $this->options = array_merge($this->options, ['parse_mode' => 'HTML']);
    }
}
