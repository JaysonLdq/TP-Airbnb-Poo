<?php

namespace App\Controller;

use App\Model\Repository\RepoManager;
use PDO;

use Symplefony\Controller;
use Symplefony\Database;
use Symplefony\View;

use App\Model\UserModel;
class PageController extends Controller
{
    // Page d'accueil
    public function index(): void
    {
        $view = new View( 'page:home' );

        $data = [
            'title' => 'Accueil - Havenly.com'
        ];

        $view->render( $data );
    }

    // Page de location
    public function location(): void
    {
        $view = new View( 'page:rentals:location' );

        $data = [
            'title' => 'Locations - Havenly.com'
        ];

        $view->render( $data );

       
    }

    public function indexLogement(): void
    {
        // Récupérer les logements depuis le repository
        $logements = RepoManager::getRM()->getLogementRepo()->getAll();
        $logementRepo = RepoManager::getRM()->getLogementRepo();

        // Passer les logements à la vue
        $view = new View('page:home');
        $data = [
            'title' => 'Liste des logements',
            'logements' => $logements,
            'logementRepo' => $logementRepo
        ];

        // Rendre la vue avec les données
        $view->render($data);
    }


    

}