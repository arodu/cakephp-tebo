<?php

declare(strict_types=1);

namespace TeBo\Telegram\Command;

use TeBo\Telegram\Chat;
use TeBo\Telegram\Response\Message;
use TeBo\Telegram\Update;

class Debug extends BaseCommand
{
    /**
     * @return string
     */
    public function help(): string
    {
        return __('Show the current branch and last commit');
    }

    /**
     * @param Chat $chat
     * @param array $originalData
     * @return void
     */
    public function execute(Update $update)
    {
        $branch_name = shell_exec('git rev-parse --abbrev-ref HEAD');
        $last_commit_date = shell_exec('git log -1 --format=%ci');
        $last_commit_hash = shell_exec('git log -1 --format=%h');

        $update->getChat()->send(new Message([
            __('branch: {0}', $branch_name),
            __('commit: {0}', $last_commit_hash),
            __('{0}', $last_commit_date),
            '',
            __('https://github.com/arodu/cakephp-tebo/tree/{0}', $branch_name),
        ]));
    }
}
