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

    public function getCurentUser(): array
    {
        return $this->find($_SESSION['user_id']);
    }

    public function getUserByEmail(string $email)
    {
        return $this->db->from($this->table)
            ->where('email')->is($email)
            ->select()
            ->fetchAssoc()
            ->first();

    }
}