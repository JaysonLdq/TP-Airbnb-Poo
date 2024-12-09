<?php

namespace App\Controller;

use App\Model\Entity\User;
use App\Model\Repository\RepoManager;
use App\Model\Repository\UserRepository;
use Laminas\Diactoros\ServerRequest;

use Symplefony\Controller;
use Symplefony\View;

use Symplefony\Database;

class UserController extends Controller
{
    /**
     * Pages publiques
     */
   //Page de création de compte
   public function login(): void
   {
       $view = new View( 'page:login:register' );

       $data = [
           'title' => "S'enregistrer - Havenly.com"
       ];

       $view->render( $data );
   }

   //Page de connexion
   public function register(): void
   {
       $view = new View( 'page:connexion:connexion' );

       $data = [
           'title' => 'Se connecter - Havenly.com'
       ];

       $view->render( $data );
   }

   //Page de profil
   public function profile(): void
   {
       $view = new View( 'page:profile:profil' );

       $data = [
           'title' => 'Mon profil - Havenly.com'
       ];

       $view->render( $data );
   }

    // Visiteur: Traitement du formulaire de création de compte
    public function processSubscribe(): void
    {
        // TODO: :)
    }

    /**
     * Pages Administrateur
     */

    // Admin: Affichage du formulaire de création d'un utilisateur
    public function add(): void
    {
        $view = new View( 'user:admin:create' );

        $data = [
            'title' => 'Ajouter un utilisateur'
        ];

        $view->render( $data );
    }

    // Admin: Traitement du formulaire de création d'un utilisateur
    public function create( ServerRequest $request ): void
    {
        $user_data = $request->getParsedBody();

        $user = new User( $user_data );

        $user_created = RepoManager::getRM()->getUserRepo()->create( $user );

        if( is_null( $user_created ) ) {
            // TODO: gérer une erreur
            $this->redirect( '/admin/users/add' );
        }

        $this->redirect( '/admin/users' );
    }

    // Admin: Liste
    public function index(): void
    {
        $view = new View( 'page:home' );


        $data = [
            'title' => 'Liste des utilisateurs',
            'users' => RepoManager::getRM()->getUserRepo()->getAll()
        ];

        $view->render( $data );
    }

    // Admin: Détail
    public function show( int $id ): void
    {
        $view = new View( 'user:admin:details' );

        $repo = new UserRepository( Database::getPDO() );
        $user = $repo->getById( $id );

        // Si l'utilisateur demandé n'existe pas
        if( is_null( $user ) ) {
            View::renderError( 404 );
            return;
        }

        $data = [
            'title' => 'Utilisateur: '. $user->getEmail(),
            'user' => $user
        ];

        $view->render( $data );
    }
}