<?php

use function DI\create;

$connection = include_once 'config/db.php';

return [
    'Database' => \DI\create(
        Opis\Database\Database::class
    )->constructor(
        $connection
    ),
    App\Controller::class =>
        \DI\create(App\Controller::class)
            ->constructor(DI\get('Database')),
];
