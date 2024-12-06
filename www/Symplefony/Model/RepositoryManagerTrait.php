<?php 

namespace Symplefony\Model;

use App\Model\Repository\CategoryRepository;
use App\Model\Repository\UserRepository;
use Symplefony\Database;

trait RepositoryManagerTrait
{
    private static ?self $rm_instance = null;
    public static function getRM(): self
    {
        if( is_null( self::$rm_instance ) ) {
            self::$rm_instance = new self();
        }

        return self::$rm_instance;
    }
    public function __wakeup(){
        throw new \Exception("Interdit ! ");
    }
    private function __construct() {
        $pdo = Database::getPDO();

        $this->user_repo = new UserRepository( $pdo );
        $this->category_repo = new CategoryRepository( $pdo );
    }
    private function __clone() {}
}