<?php
declare(strict_types=1);

namespace TeBo\Dto;

use TeBo\Utility\Trait\DataManageTrait;

class User
{
    use DataManageTrait;

    protected int $id;
    protected bool $isBot;
    protected string $firstName;
    protected ?string $lastName;
    protected ?string $username;

    /**
     * @param array $userData El array de datos del usuario desde la API.
     */
    public function __construct(array $userData)
    {
        $this->setOriginalData($userData);
        $this->id = (int)$userData['id'];
        $this->isBot = (bool)$userData['is_bot'];
        $this->firstName = (string)$userData['first_name'];
        $this->lastName = $userData['last_name'] ?? null;
        $this->username = $userData['username'] ?? null;
    }

    /**
     * El ID único del usuario.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * El primer nombre del usuario.
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * El apellido del usuario (opcional).
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * El @username del usuario (opcional).
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * Devuelve true si el usuario es un bot.
     */
    public function isBot(): bool
    {
        return $this->isBot;
    }
}