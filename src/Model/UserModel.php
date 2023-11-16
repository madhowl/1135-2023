<?php

declare(strict_types=1);


namespace App\Model;


use Opis\Database\Database;

class UserModel extends \App\Core\CoreModel implements ModelInterface
{
    /**
     * UserModel constructor.
     */
    public function __construct(Database $db)
    {
        parent::__construct( $db);
        $this->setTable('users');
    }

    public function getCurentUser(int $id): array
    {
        return $this->find($id);
    }

    public function getUserByEmail(string $email)
    {
        return $this->db->from($this->table)
            ->where('email')->is($email)
            ->select()
            ->fetchAssoc()
            ->first();

    }

    public function paginate(int $limit, int $offset): array
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