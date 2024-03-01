<?php
declare(strict_types=1);

namespace TeBo\Telegram\Command;

use Cake\Utility\Text;

abstract class BaseCommand implements CommandInterface
{
    protected array $args = [];

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
}
