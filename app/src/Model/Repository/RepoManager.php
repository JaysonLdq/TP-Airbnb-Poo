<?php 

namespace App\Model\Repository;


use Symplefony\Database;
use Symplefony\Model\RepositoryManagerTrait;

class RepoManager
{
    use RepositoryManagerTrait;

    private UserRepository $user_repo;
    public function getUserRepo(): UserRepository { return $this->user_repo; }

    private CategoryRepository $category_repo;
    public function getCategoryRepo(): CategoryRepository { return $this->category_repo; }

    private LogementRepository $logement_repo;
    public function getLogementRepo(): LogementRepository { return $this->logement_repo; }

    private LocationRepository $location_repo;
    public function getLocationRepo(): LocationRepository { return $this->location_repo; }
    


    private function __construct()
    {
        $pdo = Database::getPDO();

        $this->user_repo = new UserRepository( $pdo );
        $this->category_repo = new CategoryRepository( $pdo );
        $this->logement_repo = new LogementRepository( $pdo );
        $this->location_repo = new LocationRepository( $pdo );
    
        
    }

}