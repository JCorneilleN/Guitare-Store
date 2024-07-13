<?php

// Database connection parameters
$host_address = 'localhost';
$database_name = 'my_guitar_shop';
$username = 'CS351user';
$password = '';

// Establish a PDO database connection
try {
    $data_source_name = "mysql:host=$host_address;dbname=$database_name";
    $db = new PDO($data_source_name, $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    $error_message = $e->getMessage();
    include('../view/database_error.php');
    exit();
}
?>