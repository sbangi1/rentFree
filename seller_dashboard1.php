<?php
session_start();
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "propertydb";


require_once "registerSQL.php";

// Get seller_id of logged-in user
$seller_id = $_SESSION["seller_id"];

// Create a mysqli instance
$conn = new mysqli($host, $user, $pass, $dbname);

// Check if there was an error connecting to the database
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare the SQL statement
$sql = "SELECT COUNT(*) as count FROM properties WHERE seller_id = ?";
$stmt = $conn->prepare($sql);

// Bind the parameters
$stmt->bind_param("i", $seller_id);

// Execute the statement
$stmt->execute();

// Get the result
$result = $stmt->get_result();

// Fetch the count
$count = $result->fetch_assoc()["count"];

// If user has properties stored, redirect to seller dashboard
if ($count > 0) {
    header("Location: seller_dashboard.php");
    exit();
}

// Close the connection
$stmt->close();
$conn->close();
?>



<!DOCTYPE html>
<html>
  <head>
    <link href="seller.css" type="text/css" rel="stylesheet" />
    <title>Add Property</title>
  </head>
  <body>
  <div id="add-property">
<a href="seller_dashboard.php"><img src="plus.png" alt="Add Property" id="plus" style="width: 30%; height: auto;"></a>
  <h2>It seems you have no properties listed! Press the plus to add your first property!</h2>
</div>
  </body>
</html>