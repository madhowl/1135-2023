<?php


namespace App\Core;


use Opis\Database\Database;

class ArticleModel extends CoreModel implements \App\Model\ModelInterface
{
    public function __construct(Database $db)
    {
        parent::__construct($db);
        $this->setTable('articles');
    }

}