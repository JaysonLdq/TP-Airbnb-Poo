<?php

namespace App\Model\Repository;

use App\Model\Entity\User;
use PDO;
use Symplefony\Model\Repository;

class UserRepository extends Repository
{


   
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
            (`password`,`email`,`firstname`,`lastname`,`phone_number`,`role_id`) 
            VALUES (:password,:email,:firstname,:lastname,:phone_number,:role_id)',
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
            'role_id' => $user->getRole(),
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
            $user = new User($user_data);
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
            $user = new User($user_data);
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
            $user = new User($user_data);
            return $user;
        }

        return null; // L'utilisateur n'a pas été trouvé
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

        public function checkAuth( string $email, string $password ): ?User
    {
		$query = sprintf(
			'SELECT * FROM `%s` WHERE `email`=:email AND `password`=:password',
			$this->getTableName()
		);
		$sth = $this->pdo->prepare( $query );
		if( ! $sth ) {
            return null;
        }
		$sth->execute( [ 'email' => $email, 'password' => $password ] );
		$user_data = $sth->fetch();
		if( ! $user_data ) {
            return null;
        }
		return new User( $user_data );
    }
}
