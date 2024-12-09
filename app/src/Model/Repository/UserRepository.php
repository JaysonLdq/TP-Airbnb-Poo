<?php

namespace App\Model\Repository;

use Symplefony\Model\Repository;

use App\Model\Entity\User;

class UserRepository extends Repository
{
    protected function getTableName(): string { return 'users'; }

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
        'phone_number' => $user->getPhoneNumber()
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
        return $this->readAll( User::class );
    }

    /* cRud: Read un item par son id */
    public function getById( int $id ): ?User
    {
        return $this->readById( User::class, $id );
    }
}