<?php

namespace App\Controller;

use App\Model\Entity\Logement;
use App\Model\Entity\User;
use App\Model\Repository\RepoManager;
use App\Model\Repository\UserRepository;
use Laminas\Diactoros\ServerRequest;
use PDO;
use Symplefony\Controller;
use Symplefony\View;

use Symplefony\Database;

class UserController extends Controller
{
    /**
     * Pages publiques
     */
   //Page de création de compte
   public function login(ServerRequest $request): void
    {

     // Récupérer les données du formulaire
     $user_data = $request->getParsedBody();
    



     // Vérifier si les données sont présentes
    if (isset($user_data['email']) && isset($user_data['password'])) {
        // Charger le repository de l'utilisateur
        $repo = RepoManager::getRM()->getUserRepo();

       // Récupérer l'utilisateur par email
         $user = $repo->getByEmail($user_data['email']);

         // Vérifier si l'utilisateur existe et si le mot de passe est correct
         if ($user && password_verify($user_data['password'], $user->getPassword())) {
             // Si la connexion est réussie, l'utilisateur est authentifié
             // Stocker les informations utilisateur dans la session
             $_SESSION['id'] = $user->getId();  // Stocke l'ID de l'utilisateur dans la session
             $_SESSION['email'] = $user->getEmail();  // Stocke l'email de l'utilisateur dans la session
             $_SESSION['firstname'] = $user->getFirstname();  // Stocke le prénom de l'utilisateur
             $_SESSION['lastname'] = $user->getLastname();  // Stocke le nom de l'utilisateur
             $_SESSION['role_id'] = $user->getRole();  // Stocke le rôle de l'utilisateur
            

             // Rediriger l'utilisateur vers la page d'accueil ou profil
             header('Location: /');  // Redirige vers la page du profil
             exit(); 
         } else {
             // Si l'utilisateur n'existe pas ou le mot de passe est incorrect
             echo "Email ou mot de passe incorrect.";
         }
     } else {
         // Si les champs sont vides
         echo "Veuillez remplir tous les champs.";
    }
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




    // Admin: Affichage du formulaire de création d'un utilisateur
    public function add(): void
    {
        $view = new View( 'page:login:register' );

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

     //page de biens
     public function biens(): void
     {
         $view = new View( 'page:profile:biens:biens' );
 
         $data = [
             'title' => 'Mes biens - Havenly.com'
         ];
 
         $view->render( $data );
     }

     public function createBiens( ServerRequest $request ): void
     {
        $logement_data = $request->getParsedBody();
    
        

        $logement_created = RepoManager::getRM()->getLogementRepo()->createBien( $logement_data );

        if( is_null( $logement_created ) ) {
            // TODO: gérer une erreur
            $this->redirect( '/biens' );
        }

        $this->redirect( '/biens' );
        
     }

     public function showBiens(int $id): void
     {
         $view = new View('page:detailsBiens:details-biens');
     
         // Récupération du bien par son ID
         $logement = RepoManager::getRM()->getLogementRepo()->getById($id);
     
         // Si le logement n'existe pas, afficher une erreur 404
         if (is_null($logement)) {
             View::renderError(404);
             return;
         }
     
         // Récupération des réservations associées au logement
         $rentals = RepoManager::getRM()->getLocationRepo()->getByLogementId($id);
     
         // Données à passer à la vue
         $data = [
             'title' => 'Détails du bien: ',
             'logement' => $logement,
             'rentals' => $rentals // On passe les réservations à la vue
         ];
     
         $view->render($data);
     }

     
}