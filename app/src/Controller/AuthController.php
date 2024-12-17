<?php

namespace App\Controller;

use App\Controller\Database as ControllerDatabase;
use App\Model\Entity\User as EntityUser;

use Symplefony\Controller;
use App\Model\Entity\User;
use App\Controller\Database;
use App\Model\Repository\RepoManager;
use App\Session;
use Laminas\Diactoros\ServerRequest;
use PDO;
use Symplefony\View;

class AuthController extends Controller
{

    
// --- Vérifications des rôles ---
public static function isAdmin(): bool
{
    return self::isAuth() && ($_SESSION['role_id'] ?? null) === User::ROLE_ADMIN;
}

public static function isAuth(): bool
{
    return !is_null(Session::get(Session::USER));
}

public static function isProprietaire(): bool
{
    return self::isAuth() && ($_SESSION['role_id'] ?? null) === User::ROLE_PROPRIETAIRE;
}

public static function isUser(): bool
{
    return self::isAuth() && ($_SESSION['role_id'] ?? null) === User::ROLE_LOCATAIRE;
}

public static function isVisitor(): bool
{
    return !self::isAuth();
}

// --- Actions de routes ---
// - Visiteurs seulement -
/**
 * Affiche le formulaire de connexion
 */
public function signIn(): void
{
    $view = new View('page:connexion:connexion');
    $data = [
        'title' => 'Connexion - Havenly.com'
    ];
    $view->render($data);
}

/**
 * Traitement du formulaire de connexion
 */
public function checkCredentials(ServerRequest $request): void
{
    $form_data = $request->getParsedBody();

    // Vérification des données du formulaire
    if (empty($form_data['email']) || empty($form_data['password'])) {
        $this->redirect('/connexion'); // Redirection en cas de champs vides
    }

    $email = trim($form_data['email']);
    $password = trim($form_data['password']);

    if (empty($email) || empty($password)) {
        $this->redirect('/connexion');
    }

    // Vérification des identifiants
    $user = RepoManager::getRM()->getUserRepo()->checkAuth($email, $password);

    if (is_null($user)) {
        $this->redirect('/connexion'); // Redirection en cas d'échec
    }

    // Enregistrement de l'utilisateur en session
    Session::set(Session::USER, $user);

    // Redirection selon le rôle de l'utilisateur
    $redirect_url = match ($user->getRole()) {
        User::ROLE_LOCATAIRE => '/rooms-user',
        User::ROLE_PROPRIETAIRE => '/rooms-owner',
        User::ROLE_ADMIN => '/dashboard',
        default => '/' // Redirection par défaut
    };

    $this->redirect($redirect_url);
}

/**
 * Déconnexion
 */
public function signOut(): void
{
    Session::remove(Session::USER);
    $this->redirect('/');
}   
}



