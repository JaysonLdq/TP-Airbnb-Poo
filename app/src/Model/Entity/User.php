<?php

namespace App\Model\Entity;

use PDO;
use Symplefony\Model\Entity;


class User extends Entity
{

    
    
    
    protected string $password;
    public function getPassword(): string { return $this->password; }
    public function setPassword( string $value ): self
    {
        $this->password = password_hash($value, PASSWORD_DEFAULT);
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

     private PDO $pdo;

        public function __construct(PDO $pdo)
        {
            $this->pdo = $pdo;
        }

        

     // Méthode findByEmail pour récupérer un utilisateur par son email
    public function findByEmail($email)
    {
        // Prépare la requête SQL pour rechercher un utilisateur par son email
        $query = "SELECT * FROM users WHERE email = :email";
       

        $stmt = $this->pdo->prepare($query);

        // Lie le paramètre email à la valeur donnée
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        // Exécute la requête
        $stmt->execute();

        // Récupère le résultat
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Si l'utilisateur existe, retourne ses informations
        if ($user) {
            return $user;
        }

        // Si aucun utilisateur n'est trouvé, retourne null
        return null;
    }

    
   
}