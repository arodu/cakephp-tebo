<?php

declare(strict_types=1);

namespace TeBo\Action;

use Cake\Core\Configure;
use TeBo\Action\Action;
use TeBo\Dto\Update;
use TeBo\Utility\Bot;

class DefaultAction extends Action
{
    /**
     * @inheritDoc
     */
    public function execute(): void
    {
        if (!Configure::read('debug')) {
            return;
        }

        $this->getChat()->sendHtml([
            'Default action executed.',
            'Update ID: ' . $this->getUpdate()->getUpdateId(),
            '',
            'You can customize this action by creating your own action class that extends \TeBo\Action\Action and overrides the execute() method.',
        ]);
    }
}
