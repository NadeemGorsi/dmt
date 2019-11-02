<?php
if(empty($_POST)) {
    die("Something Wrong...");
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = $_POST['new_db_name'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$new_db = $_POST['new_db_name'];
$old_db = $_POST['old_db_name'];
$category = isset($_POST['category_of_data']) ? $_POST['category_of_data'] : $_POST['old_db_name'];
dataMigration($conn, $new_db, $old_db, $category);

function dataMigration($conn, $new_db, $old_db, $category) {
    $sql = "INSERT INTO $new_db.subscribers (email, date_added, category) 
    SELECT email, date_added, '$category' FROM $old_db.subscribers;";
    
    if ($conn->query($sql) === TRUE) {
        echo "<h3>Data Migration Successfull...<h3>";
    } else {
        echo "Error: " . $conn->error;
        //echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
