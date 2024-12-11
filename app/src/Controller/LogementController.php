<?php
namespace App\Controller;

use App\Model\Repository\LogementRepository;
use App\Model\Repository\RepoManager;
use App\Model\Entity\Logement;
use Symplefony\View;

class LogementController
{
    // Afficher tous les logements
    public function index(): void
    {
        // Récupérer les logements depuis le repository
        $logements = RepoManager::getRM()->getLogementRepo()->getAll();

        // Passer les logements à la vue
        $view = new View('page:home');
        $data = [
            'title' => 'Liste des logements',
            'logements' => $logements
        ];

        // Rendre la vue avec les données
        $view->render($data);
    }
}
