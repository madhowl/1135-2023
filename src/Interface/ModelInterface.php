<?php


namespace App\Interface;


interface ModelInterface
{
    public function all(): mixed;

    public function find(int $id): mixed;

    public function count(): int;
}