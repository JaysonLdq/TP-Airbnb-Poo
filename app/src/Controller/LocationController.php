<?php 

namespace App\Controller;

use App\Model\Repository\RepoManager;
use Laminas\Diactoros\ServerRequest;
use Symplefony\Controller;
use Symplefony\View;

class LocationController extends Controller
{
    // Afficher les détails d'un logement
   public function showLogement(int $id): void
{
    // Récupérer les détails du logement
    $logement = RepoManager::getRM()->getLogementRepo()->getById($id);

    if ($logement) {
        // Charger la vue location.phtml
        $view = new View('page:rentals:location');
        $data = [
            'title' => 'Détails du logement - ',
            'logement' => $logement
        ];
        $view->render($data);
    } else {
        // Si le logement n'existe pas, afficher une erreur
        View::renderError(404);
    }

    
}

public function createReservation( ServerRequest $request, $id ): void
     {
        $location_data = $request->getParsedBody();
        
        $data_location = [
            'rental_date' => htmlspecialchars($location_data['rental_date']),
            'end_date' => htmlspecialchars($location_data['end_date']),
            'logement_id' => $id,
            'user_id' => $_SESSION['id']
        ];
        
        $location_created = RepoManager::getRM()->getLocationRepo()->createReservation($data_location);


        if( !$location_created ) {
            // TODO: gérer une erreur
            $this->redirect( '/' );
        }

        $this->redirect( '/' );
        
     }

     // Afficher toutes les locations 
        public function meslocation(): void
        {
            // Récupérer les locations depuis le repository
            $locations = RepoManager::getRM()->getLocationRepo()->getAll();
    
            // Passer les locations à la vue
            $view = new View('page:profile:mesLocations:MesBiens');
            $data = [
                'title' => 'Liste des locations',
                'locations' => $locations
            ];
    
            // Rendre la vue avec les données
            $view->render($data);
        }
}