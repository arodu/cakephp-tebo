<?php
declare(strict_types=1);

namespace TeBo\TeBo;

use Cake\Core\Configure;
use Cake\Utility\Text;

abstract class AbstractCommand implements CommandInterface
{
    protected array $args = [];

    protected bool $debug = false;

    /**
     * @param array $args
     */
    public function __construct(array $args = [])
    {
        $this->args = $args;
    }

    /**
     * @return array
     */
    public function getArgs(): array
    {
        return $this->args;
    }

    /**
     * @return string
     */
    public static function getDefaultName(): string
    {
        // @todo refactor
        return Text::slug(static::class);
    }

    /**
     * @return string
     */
    public function help(): string
    {
        return __('No help available');
    }

    /**
     * @return boolean
     */
    public function allowExecute(): bool
    {
        if (!$this->debug) {
            return true;
        }

        if (Configure::read('tebo.debug') || Configure::read('debug')) {
            return true;
        }

        return false;
    }
}
