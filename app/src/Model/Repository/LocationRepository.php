<?php

namespace App\Model\Repository;

use App\Model\Entity\Location;
use PDO;
use PDOException;
use Symplefony\Model\Repository;

class LocationRepository extends Repository
{
    // Retourne le nom de la table
    protected function getTableName(): string
    {
        return 'rentals'; // Table des réservations
    }

    /**
     * Crée une nouvelle réservation.
     *
     * @param array $data_location
     * @return bool
     */
    public function createReservation(array $data_location): bool
    {
        // Préparer la requête SQL
        $sql = "INSERT INTO rentals (user_id, logement_id, rental_date, end_date) 
                VALUES (:user_id, :logement_id, :rental_date, :end_date)";
        
        try {
            // Préparer la requête
            $stmt = $this->pdo->prepare($sql);
            
            // Exécuter la requête avec les données
            if ($stmt->execute($data_location)) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            // Gérer l'erreur
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }

    /**
     * Récupère toutes les réservations.
     *
     * @return array
     */
    public function getAll(): array
    {
        $locationsArray = $this->readAll(Location::class);
        return $locationsArray;
    }

    /**
     * Récupère une réservation par son ID.
     *
     * @param int $id
     * @return Location|null
     */
    public function getById(int $id): ?Location
    {
        $location = $this->readById(Location::class, $id);
        return $location;
    }

    /**
     * Récupère les réservations associées à un logement spécifique.
     *
     * @param int $logementId
     * @return array
     */
    public function getByLogementId(int $logementId): array
    {
        $query = 'SELECT * FROM rentals WHERE logement_id = :logement_id';
        
        try {
            $sth = $this->pdo->prepare($query);
            $sth->execute(['logement_id' => $logementId]);

            $rentals = [];
            while ($rentalData = $sth->fetch(PDO::FETCH_ASSOC)) {
                $rentals[] = $rentalData;
            }

            return $rentals;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return [];
        }
    }
}

?>
