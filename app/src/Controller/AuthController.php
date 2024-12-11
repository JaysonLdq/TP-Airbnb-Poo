<?php

namespace App\Controller;

use App\Controller\Database as ControllerDatabase;
use App\Model\Entity\User as EntityUser;

use Symplefony\Controller;
use App\Model\Entity\User;
use App\Controller\Database;
use PDO;

class AuthController extends Controller
{

    
    public static function isAdmin(): bool
    {
        // TODO: Le vrai contrôle de session
        return true;
    }

    public function login(array $data) {
        
$email = $_POST['email'];
$password = $_POST['password'];

// Créer une instance de ton modèle User pour rechercher l'utilisateur par email
$pdo = new PDO('mysql:host=localhost;dbname=mydatabase', 'username', 'password');
$userModel = new User($pdo);
$user = $userModel->findByEmail($email);  // Trouve l'utilisateur par email

// Vérifier si l'utilisateur existe et que le mot de passe est correct
if ($user && password_verify($password, $user['password'])) {
    // Connexion réussie, démarrer la session et stocker les données utilisateur
    SessionController::start();  // Démarre la session PHP
    SessionController::set('user_id', $user['id']);  // Stocke l'ID utilisateur dans la session
    SessionController::set('email', $user['email']);  // Stocke l'email
    SessionController::set('firstname', $user['firstname']);  // Stocke le prénom
    
    // Optionnel: rediriger vers la page de profil ou une autre page après connexion
    header('Location: /profil');  // Rediriger vers la page de profil
    exit();
} else {
    // Si la connexion échoue
    echo "Identifiants incorrects.";
}

    }

    public function logout() {
        // Détruire la session
        SessionController::destroy();
        
        // Rediriger l'utilisateur vers la page d'accueil
        header('Location: /');
        exit();
    }
}