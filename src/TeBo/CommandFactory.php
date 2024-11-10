<?php

declare(strict_types=1);

namespace TeBo\TeBo;

use Cake\Core\Configure;
use Cake\Log\Log;
use Cake\Utility\Hash;
use Cake\Utility\Inflector;
use TeBo\Telegram\Update;

class CommandFactory
{
    /**
     * @param \TeBo\Telegram\Update $update
     * @return CommandInterface
     */
    public static function build(Update $update): ?CommandInterface
    {
        $commandMap = Configure::read('tebo.command.mapper');
        $commandName = $update->getCommandName();
        $commandClass = Hash::get($commandMap, $commandName);
        if (
            !empty($commandClass)
            && class_exists($commandClass)
            && is_subclass_of($commandClass, CommandInterface::class)
        ) {
            return new $commandClass();
        }

        $commandClass = static::getComandFromNamespaces($commandName);
        if (!empty($commandClass)) {
            return new $commandClass();
        }

        return static::getDefaultCommand() ?? null;
    }

    /**
     * @param string $name
     * @return string|null
     */
    public static function getComandFromNamespaces(string $name): ?string
    {
        $namespaces = Configure::read('tebo.command.namespaces', []);

        foreach ($namespaces as $namespace) {
            $className = $namespace . '\\' . Inflector::classify($name);
            if (class_exists($className) && is_subclass_of($className, CommandInterface::class)) {
                return $className;
            }
        }

        return null;
    }

    /**
     * @return CommandInterface|null
     */
    public static function getDefaultCommand(): ?CommandInterface
    {
        $commandClass = Configure::read('tebo.command.mapper.default', null);
        if (
            !empty($commandClass)
            && class_exists($commandClass)
            && is_subclass_of($commandClass, CommandInterface::class)
        ) {
            return new $commandClass();
        }

        Log::warning('Default command not found!');

        return null;
    }
}
