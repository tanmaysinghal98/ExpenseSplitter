<?php
require_once('Database.php');
require_once('Credentials.php');

$db = new Db(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);

session_start();
var_dump($_SESSION['GroupId']);
// var_dump($response);


 ?>
