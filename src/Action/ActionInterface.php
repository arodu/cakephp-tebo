<?php

declare(strict_types=1);

namespace TeBo\Action;

use TeBo\Telegram\Update;

interface ActionInterface
{

    /**
     * ActionInterface constructor.
     *
     * @param Update|null $update
     * @param array $config
     */
    public function __construct(?Update $update, array $config = []);

    /**
     * Execute the action with the given update.
     * 
     * @param Update $update
     * @return void
     */
    public function execute(): void;

    /**
     * The command description for the help command.
     *
     * @return string|null
     */
    public static function description(): ?string;
}
