<?php
/**
 * Classe de démarrage de l'application
 */

// Déclaration du namespace de ce fichier
namespace App;

use Exception;
use Throwable;

use MiladRahimi\PhpRouter\Router;
use MiladRahimi\PhpRouter\Exceptions\RouteNotFoundException;
use MiladRahimi\PhpRouter\Routing\Attributes;

use Symplefony\View;

use App\Controller\AdminController;
use App\Controller\LocationController;
use App\Controller\LogementController;
use App\Controller\PageController;
use App\Controller\UserController;
use App\Middleware\AdminMiddleware;

final class App
{
    private static ?self $app_instance = null;

    // Le routeur de l'application
    private Router $router;
    public function getRouter(): Router { return $this->router; }

    public static function getApp(): self
    {
        // Si l'instance n'existe pas encore on la crée
        if( is_null( self::$app_instance ) ) {
            self::$app_instance = new self();
        }

        return self::$app_instance;
    }

    // Démarrage de l'application
    public function start(): void

    {    
        session_start();
        $this->registerRoutes();
        $this->startRouter();
    }

    private function __construct()
    {
        // Création du routeur
        $this->router = Router::create();
    }

    // Enregistrement des routes de l'application
    private function registerRoutes(): void
    {
        // -- Formats des paramètres --
        // {id} doit être un nombre
        $this->router->pattern( 'id', '\d+' );

        // -- Pages communes --
        $this->router->get( '/', [ PageController::class, 'indexLogement' ] );
        $this->router->get( '/rentals', [ LocationController::class, 'location' ]);
        $this->router->get( '/biens', [ UserController::class, 'biens' ]);
        $this->router->post( '/biens', [ UserController::class, 'createBiens' ]);
        $this->router->get( '/biens/{id}', [ UserController::class, 'showBiens' ]);
        $this->router->get('/mesLocations', [LocationController::class, 'meslocation']);
        // Route pour afficher le détail d'un logement
         // Détail
         $this->router->get( '/rentals/{id}', [ LocationController::class, 'showLogement' ] );
         $this->router->post( '/rentals/{id}', [ LocationController::class, 'createReservation' ]);

         $this->router->get( '/detailsBiens/{id}', [ UserController::class, 'showBiens' ] );

      
     


       

        

        // -- Pages utilisateurs --
        $this->router->get( '/profile', [ UserController::class, 'profile' ]);
      


        $this->router->get( '/users/connexion', [ UserController::class, 'register' ]);
        $this->router->post( '/users/connexion', [ UserController::class, 'login' ]);
       
       
        $this->router->get( '/logout', [ UserController::class, 'logout' ]);
        
        // TODO: Groupe Visiteurs (non-connectés)
        $this->router->get( '/users/add', [ UserController::class, 'add' ] );
        $this->router->post( '/users/add', [ UserController::class, 'create' ] );

        // -- Pages d'admin --
        $adminAttributes = [
            Attributes::PREFIX => '/admin',
            Attributes::MIDDLEWARE => [ AdminMiddleware::class ]
        ];

        

           
           

        $this->router->group( $adminAttributes, function( Router $router ) {
            $router->get( '', [ AdminController::class, 'dashboard' ]);

            // -- User --
            // Ajout
            // $router->get( '/users/add', [ UserController::class, 'add' ] );
            // $router->post( '/users', [ UserController::class, 'create' ] );

            // Liste
            $router->get( '/users', [ UserController::class, 'index' ]);
            // Détail
            $router->get( '/users/{id}', [ UserController::class, 'show' ] );

            

           
        });
    }

    // Démarrage du routeur
    private function startRouter(): void
    {
        try{
            $this->router->dispatch();
        }
        // Page 404 avec status HTTP adequat pour les pages non listée dans le routeur
        catch( RouteNotFoundException $e ) {
            View::renderError( 404 );
        }
        // Erreur 500 pour tout autre problème temporaire ou non
        catch( Throwable $e ) {
            View::renderError( 500 );
            var_dump( $e );
        }
    } 

    private function __clone() { }
    public function __wakeup()
    {
        throw new Exception( "Non c'est interdit !" );
    }


}

?>