<?php
declare(strict_types=1);

namespace TeBo\Telegram\Command;

use Cake\Utility\Text;

abstract class BaseCommand implements CommandInterface
{
    protected array $args = [];
    //protected bool $cancelSend = false;

    public function __construct(array $args = [])
    {
        $this->args = $args;
    }

    public function getArgs(): array
    {
        return $this->args;
    }

    public static function getDefaultName(): string
    {
        // @todo refactor
        return Text::slug(static::class);
    }
}
