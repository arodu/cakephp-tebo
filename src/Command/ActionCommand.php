<?php

declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.1.0
 * @license       https://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace TeBo\Command;

use Bake\Command\SimpleBakeCommand;
use Cake\Console\Arguments;
use Cake\Core\Configure;
use Cake\Utility\Inflector;

/**
 * Helper code generator.
 */
class ActionCommand extends SimpleBakeCommand
{
    /**
     * Task name used in path generation.
     *
     * @var string
     */
    public string $pathFragment = 'TeBo/Action/';

    /**
     * @inheritDoc
     */
    public function name(): string
    {
        return 'action';
    }

    /**
     * @inheritDoc
     */
    public function fileName(string $name): string
    {
        $parts = explode('/', $name);
        
        $name = implode(DS, array_map(function($part) {
            return Inflector::camelize($part);
        }, $parts));

        return $name . 'Action.php';
    }

    /**
     * @inheritDoc
     */
    public function template(): string
    {
        return 'TeBo.Action/action';
    }

    /**
     * Get template data.
     *
     * @param \Cake\Console\Arguments $arguments The arguments for the command
     * @return array
     * @phpstan-return array<string, mixed>
     */
    public function templateData(Arguments $arguments): array
    {
        $parent = parent::templateData($arguments);
        $parts = explode('/', $arguments->getArgumentAt(0));

        if (count($parts) > 1) {
            $dir = Inflector::camelize($parts[0]);
            $className = Inflector::camelize($parts[1]);
        } else {
            $dir = '';
            $className = Inflector::camelize($parts[0]);
        }

        $teboCommand = strtolower(str_replace('/', '_', $arguments->getArgumentAt(0)));

        return array_merge($parent, compact('dir', 'className', 'teboCommand'));
    }
}
