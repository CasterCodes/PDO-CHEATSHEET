<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'chatone';
$charset = 'utf8mb4';


// Setting the dsn - data source name

$dsn = "mysql:host={$host};dbname={$database};charste={$charset}";

// List of default options
 $options = [
       PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
       PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
       PDO::ATTR_EMULATE_PREPARES => false
 ];

 // connecting to the Database

 try {
     $conn = new PDO($dsn, $user, $password, $options);
 } catch (PDOException $e) {
     throw new PDOException($e->getMessage(). (int) $e->getCode());
     //throw $th;
 }