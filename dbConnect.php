<?php
/*
This file has the sensitive data for connecting to the database
Place it outside of the webroot, and just require it, where needed.
Make sure the links in the require functions are correct
*/

//Connect
$host = 'localhost';
$user = 'testuser';
$password = '123';
$database = 'bored-db';

// DSN - Data Source Name
$dsn = 'mysql:host='.$host.';dbname='.$database;
//Create PDO (PHP Data Object)
$pdo = new PDO($dsn, $user, $password);

//Change some settings in PDO
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ); //like turning the default fetching to return as objective
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); //And enabling prepared statements, to make sure they work even if the database driver doesn't support it

?>
