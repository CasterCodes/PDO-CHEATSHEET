<?php
include_once __DIR__. "/connection_pdo.php";

// sql query
$sql = 'SELECT * FROM users';

$stmt = $conn->query($sql);

$result = $stmt->fetchAll();

var_dump($result);

