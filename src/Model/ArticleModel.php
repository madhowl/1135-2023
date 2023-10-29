<?php


namespace App\Model;


use App\Core\CoreModel;
use App\Model\ModelInterface;
use Opis\Database\Database;

class ArticleModel extends CoreModel implements ModelInterface
{


    /**
     * ArticleModel constructor.
     */
    public function __construct(Database $db, string $table)
    {
        parent::__construct( $db);
        $this->setTable($table);
    }
}