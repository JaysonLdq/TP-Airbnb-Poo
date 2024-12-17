<?php
namespace App\Model\Repository;

use App\Controller\SessionController;
use App\Model\Entity\Adresse;
use Symplefony\Model\Repository;
use App\Model\Entity\Logement;
use PDO;

class LogementRepository extends Repository
{
    protected function getTableName(): string
    {
        return 'logement'; // La table des logements
    }

    /* Crud: Create (ajout d'un logement) */
    public function createBien(array $logement): ?array
    {
        // Vérification de la session utilisateur
        $userId = SessionController::get('id');
        if (!$userId) {
            echo "Erreur : utilisateur non connecté.";
            return null;
        }

        // 1. Insérer les données de l'adresse dans la table `adresse`
        $queryAdresse = 'INSERT INTO adresse (pays, ville, adresse, code_postal) VALUES (:pays, :ville, :adresse, :code_postal)';
        $sthAdresse = $this->pdo->prepare($queryAdresse);

        if (!$sthAdresse) {
            echo "Erreur de préparation de la requête d'adresse: " . implode(", ", $this->pdo->errorInfo());
            return null;
        }

        $successAdresse = $sthAdresse->execute([
            'pays' => $logement['pays'],
            'ville' => $logement['ville'],
            'adresse' => $logement['adresse'],
            'code_postal' => $logement['code_postal']
        ]);

        if (!$successAdresse) {
            echo "Erreur lors de l'exécution de la requête d'adresse: " . implode(", ", $sthAdresse->errorInfo());
            return null;
        }

        // 2. Récupérer l'ID de l'adresse insérée
        $adresseId = (int) $this->pdo->lastInsertId();
        if (!$adresseId) {
            echo "Erreur: ID d'adresse non récupéré.";
            return null;
        }

        // 3. Gérer l'upload d'image
        $image_name = null;
        if (!empty($_FILES['image']['name'])) {
            $image = $_FILES['image']['name'];
            $format = $_FILES['image']['type'];
            $tmp_name = $_FILES['image']['tmp_name'];
            $dir_name = __DIR__ . '/../../../public/image/';

            if (!in_array($format, ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'])) {
                echo "Erreur : Format d'image non pris en charge.";
                return null;
            }

            // Nom unique pour l'image
            $image_name = uniqid() . '_' . $image;

            if (!move_uploaded_file($tmp_name, $dir_name . $image_name)) {
                echo "Erreur : Impossible de déplacer l'image.";
                return null;
            }
        }

        // Si aucune image n'est fournie, définir une valeur par défaut (par exemple, une image générique)
        $image_name = $image_name ?? ''; // Si $image_name est null, on utilise une chaîne vide

        // 4. Insérer le logement dans la table `logement`
        $queryLogement = sprintf(
            'INSERT INTO `%s` (`type_id`, `adresse_id`, `proprietaire_id`, `price`, `date_added`, `image`, `description`, `nb_rooms`, `surface`) 
            VALUES (:type_id, :adresse_id, :proprietaire_id, :price, :date_added, :image, :description, :nb_rooms, :surface)',
            $this->getTableName()
        );

        $sthLogement = $this->pdo->prepare($queryLogement);

        if (!$sthLogement) {
            echo "Erreur de préparation de la requête de logement: " . implode(", ", $this->pdo->errorInfo());
            return null;
        }

        $successLogement = $sthLogement->execute([
            'type_id' => $logement['type_id'],
            'adresse_id' => $adresseId, // L'ID de l'adresse insérée
            'proprietaire_id' => $userId, // Utilisation de l'ID de l'utilisateur connecté
            'price' => $logement['price'],
            'date_added' => $logement['date_added'],
            'image' => $image_name,
            'description' => $logement['description'],
            'nb_rooms' => $logement['nb_rooms'],
            'surface' => $logement['surface'],
        ]);

        if (!$successLogement) {
            echo "Erreur lors de l'exécution de la requête de logement: " . implode(", ", $sthLogement->errorInfo());
            return null;
        }

        // Ajouter l'ID du logement à notre tableau associatif
        $logement['id'] = (int) $this->pdo->lastInsertId();

        // 5. Insérer les équipements associés dans la table `logement_equipements`
        if (!empty($logement['equipements']) && is_array($logement['equipements'])) {
            $queryEquipement = 'INSERT INTO logement_equipements (logement_id, equipement_id) VALUES (:logement_id, :equipement_id)';
            $sthEquipement = $this->pdo->prepare($queryEquipement);

            foreach ($logement['equipements'] as $equipementId) {
                $successEquipement = $sthEquipement->execute([
                    'logement_id' => $logement['id'], // ID du logement inséré
                    'equipement_id' => $equipementId
                ]);

                if (!$successEquipement) {
                    echo "Erreur lors de l'insertion des équipements: " . implode(", ", $sthEquipement->errorInfo());
                }
            }
        }

        return $logement;
    }

    // Récupérer tous les logements
    public function getAll(): array
    {
       $logementsArray = $this->readAll(Logement::class);

        return $logementsArray;
    }

    // Récupérer un logement par son ID
    public function getById(int $id): ?Logement
    {
        $logement = $this->readById(Logement::class, $id);

        return $logement;
    }

    public function getAdresseById(int $adresse_id): ?array
    {
        $query = 'SELECT * FROM adresse WHERE adresse_id = :adresse_id';
        $sth = $this->pdo->prepare($query);
        $sth->execute(['adresse_id' => $adresse_id]);

        $adresse = $sth->fetch(PDO::FETCH_ASSOC);
      
        return $adresse;
    }
    

    
}
