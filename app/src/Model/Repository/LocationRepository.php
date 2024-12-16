<?php

namespace App\Model\Repository;

use App\Controller\SessionController;
use Symplefony\Model\Repository;
use App\Model\Entity\Location;
use PDO;
use PDOException;

class LocationRepository extends Repository
{


    protected function getTableName(): string
    {
        return 'rentals'; // La table des logements
    }

    // Méthode pour insérer une réservation dans la table rentals
    public function createReservation(array $data_location): bool
     {
       

        // Préparer la requête SQL
        $sql = "INSERT INTO rentals (user_id,logement_id, rental_date, end_date) VALUES (:user_id, :logement_id, :rental_date, :end_date)";
        
        try {
            // Préparer la requête
            $stmt = $this->pdo->prepare($sql);
            
            // Exécuter la requête
            if ($stmt->execute($data_location)) {
                // Retourner un message ou une valeur de succès
                return true; // ou tu peux retourner l'ID de la réservation si tu veux
            } else {
                // En cas d'échec
                return false;
            }
        } catch (PDOException $e) {
            // Gérer l'erreur (enregistrer ou afficher)
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }

    // Récupérer tous les logements
    public function getAll(): array
    {
        
        $locationsArray = $this->readAll(Location::class);

        return $locationsArray;
    }


    // Récupérer un logement par son ID
    public function getById(int $id): ?Location
    {
        $location = $this->readById(Location::class, $id);

        return $location;
    }
}


?>
