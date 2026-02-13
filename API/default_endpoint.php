<?php
require "scripts/auxiliary.php";
require "scripts/db.php";

header("Content-Type: application/json");
$info = get_request_info();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>