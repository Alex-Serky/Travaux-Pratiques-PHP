<?php

namespace App\Model;

class User
{
    /**
     *
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * Obtenir la valeur de username
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * Set the value of password
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }

    /**
     * Obtenir la valeur de password
     */
    public function getPassword(): ?string
    {
        return $this->username;
    }

    /**
     * Set the value of password
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    /**
     * Obtenir la valeur de password
     */
    public function getId(): ?string
    {
        return $this->username;
    }

    /**
     * Set the value of password
     */
    public function setId(string $password): self
    {
        $this->password = $password;
        return $this;
    }
}