<?php
header("Content-Type: application/json");
require "db.php";

$action = $_POST['action'] ?? '';

switch ($action)
{
    case ("create"):
        //create contact logic
        break;

    case ("read"):
        //read contact logic
        break;

    case ("update"):
        //update contact logic
        break;


    case ("delete"):
        //delete contact logic
        break;

    default:
        break;
}

?>