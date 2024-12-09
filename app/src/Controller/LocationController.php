<?php 

namespace App\Controller;

use Symplefony\Controller;
use Symplefony\View;

class LocationController extends Controller
{
   // Page de location
   public function location(): void
   {
       $view = new View( 'page:rentals:location' );

       $data = [
           'title' => 'Locations - Havenly.com'
       ];

       $view->render( $data );

      
   }
}