<?php


namespace App\Model;


interface ModelInterface
{
    public function all(): mixed;

    public function find(int $id): mixed;

    public function count(): int;
}