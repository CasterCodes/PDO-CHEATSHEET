<?php
include_once __DIR__. "/connection_pdo.php";

// sql query 
$sql = "SELECT * FROM users WHERE last_name = ? AND email = ?";

// Prepare the sql query
$stmt = $conn->prepare($sql);


// Variables to be used
$name ='Caster';

$email = 'castercodes@gmail.com';

// Execute prepared query
$stmt->execute([$name,  $email]);

// Fetch the results
$results = $stmt->fetchAll();

// Dump the results
var_dump($results);