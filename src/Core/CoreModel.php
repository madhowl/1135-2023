<?php


namespace App\Core;


use App\Model\ModelInterface;
use Opis\Database\Database;

abstract class CoreModel implements ModelInterface
{


    protected Database $db;
    protected string $table;
    protected string $primaryKey='id';

    /**
     * @param  string  $primaryKey
     */
    public function setPrimaryKey(string $primaryKey): void
    {
        $this->primaryKey = $primaryKey;
    }

    /**
     * CoreModel constructor.
     *
     * @param  Database  $db
     */
    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    /**
     * @param  string  $table
     */
    public function setTable(string $table): void
    {
        $this->table = $table;
    }

    public function all(): array
    {
        return $this->db->from($this->table)
            ->select()
            ->fetchAssoc()
            ->all();
    }

    public function find(int $id): mixed
    {
        return $this->db->from($this->table)
            ->where('id')->is($id)
            ->select()
            ->fetchAssoc()
            ->first();
    }

    public function count(): int
    {
        return $this->db->from($this->table)->count();
    }

}