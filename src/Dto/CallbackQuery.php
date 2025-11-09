<?php
declare(strict_types=1);

namespace TeBo\Dto;

use TeBo\Utility\Trait\DataManageTrait;

class CallbackQuery
{
    use DataManageTrait;

    protected string $id;
    protected User $from;
    protected ?Message $message;
    protected string $data;

    public function __construct(array $callbackData)
    {
        $this->setOriginalData($callbackData);
        $this->id = (string) $callbackData['id'];
        $this->data = (string) $callbackData['data'];
        $this->from = new User($callbackData['from']);
        
        if (isset($callbackData['message'])) {
            $this->message = new Message($callbackData['message']);
        } else {
            $this->message = null;
        }
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getFrom(): User
    {
        return $this->from;
    }

    public function getMessage(): ?Message
    {
        return $this->message;
    }

    public function getData(): string
    {
        return $this->data;
    }
}