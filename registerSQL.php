<?php
session_start();

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "propertydb";
$errors = array();

//create connection
$db = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($db->connect_error) {
  die("Connection failed: " . $db->connect_error);
}

// SQL query to create users table
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    fName VARCHAR(30) NOT NULL,
    lName VARCHAR(50) NOT NULL,
    username VARCHAR(30) NOT NULL,
    email VARCHAR(50) NOT NULL,
    password VARCHAR(70) NOT NULL,
    type VARCHAR(32) NOT NULL
  )";

if ($db->query($sql) === FALSE) {
  echo "Error creating table: " . $db->error;
} 

// SQL query to create properties table
$sql = "CREATE TABLE IF NOT EXISTS properties (
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  seller_id INT(6) UNSIGNED NOT NULL,
  name VARCHAR(50) NOT NULL,
  location VARCHAR(100) NOT NULL,
  age INT(3) NOT NULL,
  square_footage INT(6) NOT NULL,
  num_bedrooms INT(2) NOT NULL,
  num_bathrooms INT(2) NOT NULL,
  has_garden BOOLEAN NOT NULL,
  parking_availability BOOLEAN NOT NULL,
  image VARCHAR(255) NOT NULL,
  price INT(10) NOT NULL,
  FOREIGN KEY (seller_id) REFERENCES users(id)
)";

if ($db->query($sql) === FALSE) {
  echo "Error creating table: " . $db->error;
} 

// REGISTER USER
if (isset($_POST['register'])) {
    // receive all input values from the form
    $fName = mysqli_real_escape_string($db, $_POST['fName']);
    $lName = mysqli_real_escape_string($db, $_POST['lName']);
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password_1 = mysqli_real_escape_string($db, $_POST['password1']);
    $password_2 = mysqli_real_escape_string($db, $_POST['password2']);
    if (isset($_POST['gender'])) {
      $type = mysqli_real_escape_string($db, $_POST['gender']);
    } else {
      array_push($errors, "Type is required");
    }
  
  
    // form validation: ensure that the form is correctly filled ...
    // by adding (array_push()) corresponding error unto $errors array
    if ($password_1 != $password_2) {
      array_push($errors, "The two passwords do not match");
    }
  
    // first check the database to make sure 
    // a user does not already exist with the same username and/or email
    $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);
  
    if ($user) { // if user exists
      if ($user['username'] === $username) {
        array_push($errors, "Username already exists");
      }
  
      if ($user['email'] === $email) {
        array_push($errors, "Email already exists");
      }
    }
  
    // Finally, register user if there are no errors in the form
    if (count($errors) == 0) {
      $password = password_hash($password_1,PASSWORD_DEFAULT); //encrypt the password before saving in the database
  
      $query = "INSERT INTO users (fName, lName, username, email, password, type) 
            VALUES('$fName', '$lName', '$username', '$email', '$password', '$type')";
  
      mysqli_query($db, $query);

      // Set the seller_id value in the $_SESSION variable
      $_SESSION['seller_id'] = mysqli_insert_id($db);
      
   

      header('location: login.php');
    }
}
    mysqli_close($db);
