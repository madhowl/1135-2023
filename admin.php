<?php
declare(strict_types=1);
error_reporting(E_ALL);
ini_set('display_errors', 'on');
session_start();
include_once 'function.php';











dashboard();
dd(getLastArticleId());
include 'template/backend/partials/footer.php';
