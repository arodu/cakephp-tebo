<?php

declare(strict_types=1);

namespace TeBo\Action;

use TeBo\Telegram\Update;

interface ActionInterface
{
    /**
     * Execute the action with the given update.
     * 
     * @param Update $update
     * @return void
     */
    public function execute(Update $update): void;

    /**
     * The command description for the help command.
     *
     * @return string|null
     */
    public function description(): ?string;
}
