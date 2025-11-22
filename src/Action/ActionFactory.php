<?php

declare(strict_types=1);

namespace TeBo\Action;

use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Event\EventManager;
use TeBo\Dto\Message\Command;
use TeBo\Enum\UpdateType;
use TeBo\Dto\Update;
use TeBo\Exception\ActionNotFoundException;
use TeBo\TeBoPlugin;

class ActionFactory
{
    public const DEFAULT_KEY = 'default';

    /**
     * @param Update $update
     * @param array|null $actionsMap
     * @return ActionInterface|null
     */
    public static function create(Update $update, ?array $actionsMap = null): ?ActionInterface
    {
        $updateType = $update->getType();
        $actionsMap = $actionsMap ?? Configure::read('tebo.actions');
        $action = $actionsMap[$updateType->value]
            ?? $actionsMap[self::DEFAULT_KEY]
            ?? null;

        if (empty($action)) {
            return null;
        }

        if (is_callable($action)) {
            $action = $action($update);
        }

        if (is_array($action) && $updateType === UpdateType::COMMAND) {
            $message = new Command($update->get('message'));
            $commandMap = $action;
            $action = $commandMap[$message->getCommandName()]
                ?? $commandMap[self::DEFAULT_KEY]
                ?? $actionsMap[self::DEFAULT_KEY]
                ?? null;
        }

        if (is_array($action) && $updateType === UpdateType::CALLBACK_QUERY) {
            $actionKey = $update->get('callback_query.data');
            $callbackQueryMap = $action;
            $action = $callbackQueryMap[$actionKey]
                ?? $callbackQueryMap[self::DEFAULT_KEY]
                ?? $actionsMap[self::DEFAULT_KEY]
                ?? null;
        }

        if (is_string($action) && class_exists($action) && is_subclass_of($action, ActionInterface::class)) {
            return new $action($update);
        }

        return null;
    }

    /**
     * @param Update $update
     * @param array|null $actionsMap
     * @return ActionInterface
     * @throws \RuntimeException
     */
    public static function createOrFail(Update $update, ?array $actionsMap = null): ActionInterface
    {
        $action = self::create($update, $actionsMap);
        if (empty($action)) {
            $event = new Event(TeBoPlugin::EVENT_ACTION_NOT_FOUND, null, ['update' => $update]);
            EventManager::instance()->dispatch($event);

            if (!$event->isStopped()) {
                throw new ActionNotFoundException();
            }

        }

        return $action;
    }
}
