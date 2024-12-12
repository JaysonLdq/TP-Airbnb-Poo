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
    // // Connexion PDO
    // private $pdo;

    // public function __construct($pdo) {
    //     $this->pdo = $pdo;
    // }

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
        $query = "SELECT * FROM rentals";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();

        $locations = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Convertir les résultats en objets Logement
        $locationsArray = [];
        foreach ($locations as $locationData) {
            $location = new Location($locationData['id'], $locationData['user_id'], $locationData['logement_id'], $locationData['rental_date'], $locationData['end_date']);
            $location->setId($locationData['id']);
            $location->setUserId($locationData['user_id']);
            $location->setLogementId($locationData['logement_id']);
            $location->setRentalDate($locationData['rental_date']);
            $location->setEndDate($locationData['end_date']);
            $locationsArray[] = $location;
        }

        return $locationsArray;
    }


    // Récupérer un logement par son ID
    public function getById(int $id): ?Location
    {
        $query = "SELECT * FROM rentals WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $locationData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($locationData) {
            $location = new Location($locationData['id'], $locationData['user_id'], $locationData['logement_id'], $locationData['rental_date'], $locationData['end_date']);
            $location->setId($locationData['id']);
            $location->setUserId($locationData['user_id']);
            $location->setLogementId($locationData['logement_id']);
            $location->setRentalDate($locationData['rental_date']);
            $location->setEndDate($locationData['end_date']);
            return $location;
        }

        return null;
    }
}


?>
