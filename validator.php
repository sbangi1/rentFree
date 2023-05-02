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

// first check the database to make sure a user already exists with the same username and/or email
if ($_SERVER["REQUEST_METHOD"] == "POST") { // assuming this is a POST request
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password1']);

    // Validate user input data
    if (empty($username) || empty($password)) {
        array_push($errors, "Please fill in all fields");
    }

    if (count($errors) == 0) {
        $user_check_query = "SELECT * FROM users WHERE username=? LIMIT 1";
        $stmt = $db->prepare($user_check_query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = mysqli_fetch_assoc($result);

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['username'] = $user['username'];

                if ($user['type'] === 'buyer') {
                    header('Location: buyer_dashboard.php');
                    exit;
                } else if ($user['type'] === 'seller') {
                    header('Location: seller_dashboard1.php');
                    exit;
                } else if ($user['type'] === 'admin') {
                    header('Location: admin.php');
                    exit;
                } else {
                    array_push($errors, "Invalid user type");
                }
            } else {
                array_push($errors, "Wrong password");
            }
        } else {
            array_push($errors, "Invalid credentials");
        }
        if (!empty($errors)){
            foreach ($errors as $error){
                echo $error . "<br>";
            }
        }
    }
}
// Close database connection
$db->close();
?>