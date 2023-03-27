<?php
require __DIR__ . '/db/db_connection.php';
require __DIR__ . '/db/db_create.php';
require __DIR__ . '/db/db_create_tables.php';
require __DIR__ . '/db/db_import_data.php';

// Sets up the DB on your computer

// Connect to mysql. Note: Change the password in this function to your computer password.
$conn  = connectToDB();

// Create Database
createSchema($conn);

// Create Tables
createTables($conn);

// Insert Records
insertRecords($conn);

$conn->close();
echo "Connection closed successfully\n";
?>