<?php
include_once __DIR__. "/connection_pdo.php";

// sql query 
$sql = "SELECT * FROM users WHERE last_name = :last_name AND email = :email";

// Prepare the sql query
$stmt = $conn->prepare($sql);


// Variables to be used
$name ='Caster';

$email = 'castercodes@gmail.com';

//bind values
$stmt->bindParam(":last_name", $name, PDO::PARAM_STR);
$stmt->bindParam(":email", $email, PDO::PARAM_STR);

// Execute prepared query
$stmt->execute();

// Fetch the results
$results = $stmt->fetchAll();

// Dump the results
var_dump($results);