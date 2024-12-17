<?php
namespace App\Middleware;

use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class AuthMiddleware
{
    public function __invoke(ServerRequestInterface $request, callable $next): ResponseInterface
    {
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user'])) {
            // Si non, rediriger vers la page de connexion
            return new RedirectResponse('/users/connexion');
        }

        // Si l'utilisateur est connecté, laisser passer la requête
        return $next($request);
    }
}
