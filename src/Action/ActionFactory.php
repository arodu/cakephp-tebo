<?php

declare(strict_types=1);

namespace TeBo\Action;

use Cake\Core\Configure;
use TeBo\Enum\UpdateType;
use TeBo\Telegram\Update;

class ActionFactory
{
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
            ?? $actionsMap['default']
            ?? null;

        if (empty($action)) {
            return null;
        }

        if (is_callable($action)) {
            $action = $action($update);
        }

        if (is_array($action) && $updateType === UpdateType::COMMAND) {
            $commandsMap = $action;
            $action = $commandsMap[$update->getCommandName()]
                ?? $commandsMap['default']
                ?? $actionsMap['default']
                ?? null;
        }

        if (is_string($action) && class_exists($action) && is_subclass_of($action, ActionInterface::class)) {
            $action = new $action();
        }

        if ($action instanceof ActionInterface) {
            return $action;
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
            // @todo create custom exception
            throw new \RuntimeException('Action not found');
        }

        return $action;
    }
}
