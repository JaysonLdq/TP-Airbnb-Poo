<?php

namespace App\Model\Repository;

use App\Model\Entity\User;
use PDO;

class UserRepository
{
    private $pdo;

    // Constructeur pour injecter la dépendance PDO
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // Méthode pour récupérer le nom de la table
    protected function getTableName(): string
    {
        return 'users';
    }

    /* Crud: Create */
    public function create(User $user): ?User
    {
        // Hachage du mot de passe
        $hashedPassword = password_hash($user->getPassword(), PASSWORD_DEFAULT);
        $user->setPassword($hashedPassword); // Met à jour l'objet User avec le mot de passe haché

        $query = sprintf(
            'INSERT INTO `%s` 
            (`password`,`email`,`firstname`,`lastname`,`phone_number`) 
            VALUES (:password,:email,:firstname,:lastname,:phone_number)',
            $this->getTableName()
        );

        $sth = $this->pdo->prepare($query);

        // Si la préparation échoue
        if (!$sth) {
            return null;
        }

        $success = $sth->execute([
            'password' => $user->getPassword(), // Utilise le mot de passe haché
            'email' => $user->getEmail(),
            'firstname' => $user->getFirstname(),
            'lastname' => $user->getLastname(),
            'phone_number' => $user->getPhoneNumber(),
        ]);

        // Si échec de l'insertion
        if (!$success) {
            return null;
        }

        // Ajout de l'id de l'item créé en base de données
        $user->setId($this->pdo->lastInsertId());

        return $user;
    }

    /* cRud: Read tous les items */
    public function getAll(): array
    {
        $query = sprintf('SELECT * FROM `%s`', $this->getTableName());
        $sth = $this->pdo->prepare($query);
        $sth->execute();

        $users = [];
        while ($user_data = $sth->fetch(PDO::FETCH_ASSOC)) {
            $user = new User($this->pdo);
            $user->setId($user_data['id']);
            $user->setEmail($user_data['email']);
            $user->setPassword($user_data['password']);
            $user->setFirstname($user_data['firstname']);
            $user->setLastname($user_data['lastname']);
            $user->setPhoneNumber($user_data['phone_number']);
            $users[] = $user;
        }

        return $users;
    }

    /* cRud: Read un item par son id */
    public function getById(int $id): ?User
    {
        $query = sprintf(
            'SELECT * FROM `%s` WHERE id = :id',
            $this->getTableName()
        );
        $sth = $this->pdo->prepare($query);
        $sth->execute(['id' => $id]);

        $user_data = $sth->fetch(PDO::FETCH_ASSOC);

        if ($user_data) {
            $user = new User($this->pdo);
            $user->setId($user_data['id']);
            $user->setEmail($user_data['email']);
            $user->setPassword($user_data['password']);
            $user->setFirstname($user_data['firstname']);
            $user->setLastname($user_data['lastname']);
            $user->setPhoneNumber($user_data['phone_number']);
            return $user;
        }

        return null; // Aucun utilisateur trouvé
    }

    /* cRud: Read un item par son email */
    public function getByEmail(string $email): ?User
    {
        $query = sprintf(
            'SELECT * FROM `%s` WHERE email = :email',
            $this->getTableName()
        );

        $sth = $this->pdo->prepare($query);
        $sth->execute(['email' => $email]);

        $user_data = $sth->fetch(PDO::FETCH_ASSOC);

        if ($user_data) {
            $user = new User($this->pdo);
            $user->setId($user_data['id']);
            $user->setEmail($user_data['email']);
            $user->setPassword($user_data['password']); // Mot de passe haché
            $user->setFirstname($user_data['firstname']);
            $user->setLastname($user_data['lastname']);
            $user->setPhoneNumber($user_data['phone_number']);
            return $user;
        }

        return null; // L'utilisateur n'a pas été trouvé
    }
}
