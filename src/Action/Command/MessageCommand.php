<?php

declare(strict_types=1);

namespace TeBo\Action\Command;

use Cake\Core\InstanceConfigTrait;
use Cake\Utility\Hash;
use TeBo\Enum\MessageType;
use TeBo\Dto\Message;

class MessageCommand
{
    use InstanceConfigTrait;

    /**
     * @var Message
     */
    protected Message $message;

    /**
     * @var array
     */
    protected $_defaultConfig = [
        'argumentKeys' => null,
        'separator' => ' ',
        'arguments' => [],
    ];

    /**
     * @param Message $message
     * @param array $config
     */
    public function __construct(Message $message, array $config = [])
    {
        $this->message = $message;
        $this->setConfig($config);
    }

    /**
     * @param integer|array|callable|null $argumentKeys
     * @return static
     */
    public function setArgumentKeys(int|array|callable|null $argumentKeys): static
    {
        $this->setConfig('argumentKeys', $argumentKeys);

        return $this;
    }

    /**
     * @return boolean
     */
    public function isCommand(): bool
    {
        return $this->message->getType()->is(MessageType::GROUP_COMMAND);
    }

    /**
     * @return string|null
     */
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

    /**
     * @return array
     */
    public function getArguments(): array
    {
        if (empty($this->getConfig('arguments'))) {
            $text = $this->getTextArguments();
            $args = $this->parseTextToArray($text, $this->getConfig('argumentKeys'));
            $this->setArguments($args);
        }

        return $this->getConfig('arguments') ?? [];
    }

    /**
     * @param integer|string $key
     * @return mixed
     */
    public function getArgument(int|string $key): mixed
    {
        $arguments = $this->getArguments();
        return $arguments[$key] ?? null;
    }

    /**
     * @param array $args
     * @return static
     */
    public function setArguments(array $args): static
    {
        $this->setConfig('arguments', $args ?? []);

        return $this;
    }

    /**
     * @return string|null
     */
    protected function getTextArguments(): ?string
    {
        if (!$this->isCommand()) {
            return null;
        }

        $entities = Hash::get($this->message->getOriginalData(), 'entities');
        $commandEntity = array_filter($entities, fn($entity) => $entity['type'] === 'bot_command');
        $commandEntity = reset($commandEntity);

        return substr($this->message->getText(), $commandEntity['offset'] + $commandEntity['length'] + 1);
    }

    /**
     * @param string $text
     * @param integer|array|callable|null $structure
     * @return array
     * @throws \InvalidArgumentException
     */
    protected function parseTextToArray(string $text, int|array|callable|null $structure): array
    {
        if (empty($text)) {
            return [];
        }

        if (is_null($structure)) {
            return [0 => $text];
        }

        if (is_callable($structure)) {
            $result = $structure($text);
            if (!is_array($result)) {
                throw new \InvalidArgumentException('Invalid structure type, callable must return an array');
            }

            return $result;
        }

        $separator = $this->getConfig('separator', ' ');

        if (is_int($structure)) {
            $parts = explode($separator, $text, $structure);

            return array_combine(range(0, count($parts) - 1), $parts);
        }

        if (is_array($structure)) {
            $result = [];
            $keys = array_keys($structure);
            $textParts = explode($separator, $text);

            foreach ($keys as $index => $key) {
                if ($index === count($keys) - 1) {
                    $result[$key] = implode($separator, $textParts);
                } else {
                    $result[$key] = array_shift($textParts);
                }
                settype($result[$key], $structure[$key]);
            }

            return $result;
        }

        throw new \InvalidArgumentException('Invalid structure type, must be an integer, array, callable or null');
    }
}
