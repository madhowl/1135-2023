<?php


namespace App\Model;


use App\Core\CoreModel;
use Opis\Database\Database;

class ArticleModel extends CoreModel implements ModelInterface
{

    public array $fields =[
        'id',
        'title',
        'image',
        'content',

    ];

    public array $rules =[
//        'id'             => 'required',
        'title'       => 'required',
        'image'       => 'required',
        'content'     => 'required',

    ];

    public array $filter=[
        'id'          => 'whole_number',
        'title'       => 'trim|sanitize_string',
        'image'       => 'trim|sanitize_string',
        'content'     => 'trim|basic_tags',

    ];

    /**
     * ArticleModel constructor.
     */
    public function __construct(Database $db)
    {
        parent::__construct( $db);
        $this->setTable('articles');
    }

    public function paginate(int $limit, int $offset): array
    {
        return $this->db->from($this->table)
            ->limit($limit)
            ->offset($offset)
            ->select()
            ->fetchAssoc()
            ->all();


    }


}