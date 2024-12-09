<?php

namespace App\Controller;

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

    //Page de profil
    public function profile(): void
    {
        $view = new View( 'page:profile:profil' );

        $data = [
            'title' => 'Mon profil - Havenly.com'
        ];

        $view->render( $data );
    }

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
}