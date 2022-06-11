<?php

declare(strict_types=1);

namespace TeBo\Telegram\Command;

use Cake\Core\Configure;
use Cake\Utility\Inflector;
use Cake\Utility\Text;
use Exception;
use PHPUnit\Framework\Constraint\IsInstanceOf;
use TeBo\Message\TextMessage;
use TeBo\Telegram\Chat;
use TeBo\Telegram\Update;

class CommandFactory
{




    public static function build(Update $update): CommandInterface
    {
        $commandMap = Configure::read('tebo.command.map');
        $commandName = $update->getCommandName();

        if (!$update->isCommand()) {
            // @todo custom exception
            throw new Exception();
        }

        if (isset($commandMap[$commandName]['class'])) {
            $commandClass = $commandMap[$commandName]['class'];

            return new $commandClass($update->getCommandParams());
        }

        $commandClass = static::getComandByName($update->getCommandName());
        if (!empty($commandClass)) {
            return new $commandClass($update->getCommandParams());
        }

        // @todo custom exception
        throw new Exception();
    }

    public static function getComandByName(string $name): ?string
    {
        $namespaces = Configure::read('tebo.command.namespaces');

        foreach ($namespaces as $namespace) {
            $className = $namespace . '\\' . Inflector::classify($name);
            if (class_exists($className)) {
                return $className;
            }
        }

        return null;
    }
}