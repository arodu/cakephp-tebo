<?php
declare(strict_types=1);

namespace TeBo\Dto\Message;

use TeBo\Dto\Message;

class Command extends Message
{
    protected ?string $command = null;
    protected array $arguments = [];

    public function __construct(array $messageData)
    {
        parent::__construct($messageData);
        $this->parseCommand();
    }

    protected function parseCommand(): void
    {
        $text = $this->getText();
        if ($text === null) {
            return;
        }

        $entities = $this->get('entities', []);
        $commandEntity = null;
        foreach ($entities as $entity) {
            if ($entity['type'] === 'bot_command' && $entity['offset'] === 0) {
                $commandEntity = $entity;
                break;
            }
        }

        if ($commandEntity) {
            $fullCommand = substr($text, 0, $commandEntity['length']);
            $parts = explode('@', $fullCommand); 
            $this->command = $parts[0];

            $argString = trim(substr($text, $commandEntity['length']));
            if (!empty($argString)) {
                $this->arguments = str_getcsv($argString, ' ');
            }
        }
    }

    /**
     * @return string|null
     */
    public function getCommandName(): ?string
    {
        return $this->command;
    }

    /**
     * @return array
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * @param integer $index
     * @param mixed $default
     * @return string|null
     */
    public function getArgument(int $index, mixed $default = null): ?string
    {
        return $this->arguments[$index] ?? $default;
    }
}