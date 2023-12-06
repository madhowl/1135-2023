<?php


namespace App\Core;


use App\Interface\ModelInterface;
use Opis\Database\Database;

abstract class CoreModel implements ModelInterface
{


    public Database $db;
    public string $table;
    protected string $primaryKey='id';

    public array $fields=[];
    public array $rules=[];

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

    /**
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
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

    public function insert(array $properties)
    {
        return $this->db->insert($properties)
            ->into($this->table);
    }

    public function update(int $id, array $properties): int
    {
        return $this->db->update($this->table)
            ->where('id')->is($id)
            ->set($properties);
    }
    public function destroy($id): int
    {
        return $this->db->from($this->table)
            ->where('id')->is($id)
            ->delete();
    }

}