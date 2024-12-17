<?php

namespace App\Model\Entity;

use PDO;
use Symplefony\Model\Entity;


class User extends Entity
{

    /**
     * Rôle commercial
     */
    public const ROLE_PROPRIETAIRE = 9;
    /**
     * Rôle client
     */
    public const ROLE_LOCATAIRE = 8;
    /**
     * Rôle administrateur
     */
    public const ROLE_ADMIN = 10;
    /**
     * Rôle visiteur
     */
    public const ROLE_VISITOR = 1;
    
    
    protected string $password;
    public function getPassword(): string { return $this->password; }
    public function setPassword( string $value ): self
    {
        $this->password = $value;
        return $this; // Permet de "chaîner" les appels aux setters: $toto->setId(2)->setName('toto'), etc.
    }
   
    protected string $email;
    public function getEmail(): string { return $this->email; }
    public function setEmail( string $email ): void
    {
        $this->email = $email;

    }

    protected string $firstname;
    public function getFirstname(): string { return $this->firstname; }
    public function setFirstname( string $firstname ): self
    {
        $this->firstname = $firstname;
        return $this;
    }

    protected string $lastname;
    public function getLastname(): string { return $this->lastname; }
    public function setLastname( string $lastname ): self
    {
        $this->lastname = $lastname;
        return $this;
    }

    protected string $phone_number;
    public function getPhoneNumber(): string { return $this->phone_number; }
    public function setPhoneNumber( int $value ): self
    {
        $this->phone_number = $value;
        return $this;
    }

    protected  $role_id;
    public function getRole(): int { return $this->role_id; }
    public function setRole( int $role ): self
    {
        $this->role_id = $role;
        return $this;
    }


        

    

    
   
}