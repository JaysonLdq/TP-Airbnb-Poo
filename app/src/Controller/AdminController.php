<?php

namespace App\Controller;

use Symplefony\Controller;
use Symplefony\View;

class AdminController extends Controller
{
    // Dashboard
    public function dashboard(): void
    {
        $view = new View( 'page:admin:home' );

        $data = [
            'Title' => 'Tableau de bord - Admin Havenly.com'
        ];

        $view->render();
    }
}