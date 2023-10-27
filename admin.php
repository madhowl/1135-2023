<?php
declare(strict_types=1);
use Tracy\Debugger;
//error_reporting(E_ALL);
//ini_set('display_errors', 'on');

require 'vendor/autoload.php';

Debugger::enable();

session_start();
include_once 'function.php';











dashboard();
//dd(getLastArticleId());
include 'template/backend/partials/footer.php';
