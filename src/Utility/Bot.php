<?php

declare(strict_types=1);

namespace TeBo\Utility;

use Cake\Core\Configure;
use Cake\Log\Log;
use Cake\Routing\Router;
use TeBo\Action\ActionInterface;
use TeBo\Enum\UpdateType;

/**
 * Tebo command.
 */
class Bot
{
    /**
     * get url webhook to telegram api
     *
     * @return string
     */
    public static function getWebhookUrl(): string
    {
        $webhookUrl = Configure::read('tebo.webhookUrl');

        return Router::url($webhookUrl, true);
    }

    /**
     * @param string $message
     * @param array $data
     * @return void
     */
    public static function debug(string $message, array $data = []): void
    {
        if (Configure::read('debug')) {
            Log::debug($message . ': ' . json_encode($data), 'tebo');
        }
    }

    /**
     * @return array
     */
    public static function getCommandDescriptionList(): array
    {
        $commandList = [];
        $classes = Configure::read('tebo.actions.' . UpdateType::COMMAND->value);

        if (empty($classes)) {
            return [];
        }

        if (is_callable($classes)) {
            $classes = $classes();
        }

        foreach ($classes ?? [] as $command => $class) {
            if (class_exists($class) && is_subclass_of($class, ActionInterface::class)) {
                $description = $class::description();
                if ($description) {
                    $commandList[] = [
                        'command' => $command,
                        'description' => $description,
                    ];
                }
            }
        }

        return $commandList ?? [];
    }
}
