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
    public function __construct(Database $db)
    {
        parent::__construct( $db);
        $this->setTable('articles');
    }

    public function paginate(int $limit, int $offset)
    {
        return $result = $this->db->from($this->table)
            //->orderBy('name')
            ->limit($limit)
            ->offset($offset)
            ->select()
            ->fetchAssoc()
            ->all();


    }
}