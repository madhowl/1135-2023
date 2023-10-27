<?php
use Opis\Database\Connection;

return $connection = new Connection(
    'mysql:host=localhost;dbname=vdml',
    'admin',
    'admin'
);