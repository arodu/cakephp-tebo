<?php

declare(strict_types=1);

namespace TeBo\Utility;

use Cake\Core\InstanceConfigTrait;
use Cake\Utility\Hash;
use TeBo\Enum\MessageType;
use TeBo\Telegram\Message;

class MessageCommand
{
    use InstanceConfigTrait;

    protected $_defaultConfig = [
        'argumentKeys' => null,
        'separator' => ' ',
    ];

    protected Message $message;

    protected int|array|null $argumentKeys;

    public function __construct(Message $message, array $config = [])
    {
        $this->message = $message;
        $this->setConfig($config);
    }

    public function setArgumentKeys(int|array|null $argumentKeys): void
    {
        $this->setConfig('argumentKeys', $argumentKeys);
    }

    public function isCommand(): bool
    {
        return $this->message->getType()->is(MessageType::GROUP_COMMAND);
    }

    public function getCommandName(): ?string
    {
        if (!$this->isCommand()) {
            return null;
        }

        $entities = Hash::get($this->message->getOriginalData(), 'entities');
        $commandEntity = array_filter($entities, fn($entity) => $entity['type'] === 'bot_command');
        $commandEntity = reset($commandEntity);

        return substr($this->message->getText(), $commandEntity['offset'] + 1, $commandEntity['length'] - 1);
    }

    public function getTextArguments(): ?string
    {
        if (!$this->isCommand()) {
            return null;
        }

        $entities = Hash::get($this->message->getOriginalData(), 'entities');
        $commandEntity = array_filter($entities, fn($entity) => $entity['type'] === 'bot_command');
        $commandEntity = reset($commandEntity);

        return substr($this->message->getText(), $commandEntity['offset'] + $commandEntity['length'] + 1);
    }

    public function getArguments(): array
    {
        if (!$this->isCommand()) {
            return [];
        }

        $text = $this->getTextArguments();

        return $this->parseTextToArray($text, $this->getConfig('argumentKeys'));
    }

    public function getArgument(int|string $key): mixed
    {
        $arguments = $this->getArguments();

        return $arguments[$key] ?? null;
    }

    protected function parseTextToArray(string $text, int|array|null $structure): array
    {
        if (empty($text)) {
            return [];
        }

        if (is_null($structure)) {
            return [0 => $text];
        }

        if (is_int($structure)) {
            $parts = explode(' ', $text, $structure);
            return array_combine(range(0, count($parts) - 1), $parts);
        }

        if (is_array($structure)) {
            $result = [];
            $keys = array_keys($structure);
            $textParts = explode(' ', $text);

            foreach ($keys as $index => $key) {
                if ($index === count($keys) - 1) {
                    $result[$key] = implode(' ', $textParts);
                } else {
                    $result[$key] = array_shift($textParts);
                }
                settype($result[$key], $structure[$key]);
            }

            return $result;
        }

        throw new \InvalidArgumentException('El parámetro $structure debe ser un array o un número entero.');
    }
}
