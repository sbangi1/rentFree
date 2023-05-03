<?php
session_start();

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "propertydb";

// Connect to the database
$conn = mysqli_connect($host, $user, $pass, $dbname);

// Create the properties table if it doesn't exist
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
mysqli_query($conn, $sql);

// Close the database connection
mysqli_close($conn);
?>
<!DOCTYPE html>
<html>

<head>
    <link href="seller.css" type="text/css" rel="stylesheet" />
    <title>Seller Profile</title>
</head>

<body>
    <h1>Seller Profile</h1>
    <p>Welcome to your seller profile page,
        <?php echo $_SESSION['username']; ?>
    </p>
    <?php
    // Check if the seller is logged in
    if (!isset($_SESSION['seller_id'])) {
        header('Location: login.php');
        exit;
    }

    // Connect to the database
    $host = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "propertydb";
    $conn = mysqli_connect($host, $user, $pass, $dbname);


    // Get the username of the logged-in seller
    $seller_id = $_SESSION['seller_id'];
    $sql = "SELECT username FROM users WHERE id = $seller_id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $username = $row['username'];

    // Handle the add property form submission
    if (isset($_POST['submit'])) {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $image = mysqli_real_escape_string($conn, $_POST['image']);
        $location = mysqli_real_escape_string($conn, $_POST['location']);
        $age = mysqli_real_escape_string($conn, $_POST['age']);
        $square_footage = mysqli_real_escape_string($conn, $_POST['square_footage']);
        $bedrooms = mysqli_real_escape_string($conn, $_POST['num_bedrooms']);
        $bathrooms = mysqli_real_escape_string($conn, $_POST['num_bathrooms']);
        $price = mysqli_real_escape_string($conn, $_POST['price']);
        $garden = isset($_POST['garden']) ? 1 : 0;
        $parking = isset($_POST['parking']) ? 1 : 0;
        $seller_id = $_SESSION['seller_id'];

        $sql = "INSERT INTO properties (name, image, location, age, square_footage, num_bedrooms, num_bathrooms, price, has_garden, parking_availability, seller_id)
			VALUES ('$name', '$image', '$location', '$age', '$square_footage', '$bedrooms', '$bathrooms', $price, $garden, $parking, $seller_id)";

        mysqli_query($conn, $sql);
    }

    // Get the properties for the logged-in seller
    $seller_id = $_SESSION['seller_id'];
    $sql = "SELECT * FROM properties WHERE seller_id = $seller_id";
    $result = mysqli_query($conn, $sql);

    // Loop through the properties and display them in cards
    ?>
    <div class="contain">
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="card">';
                echo '<img src="' . $row['image'] . '" alt="' . $row['name'] . '">';
                echo '<h2>' . $row['name'] . '</h2>';
                echo '<ul>';
                echo '<li><strong>Location:</strong> ' . $row['location'] . '</li>';
                echo '<li><strong>Age:</strong> ' . $row['age'] . '</li>';
                echo '<li><strong>Square Footage:</strong> ' . $row['square_footage'] . '</li>';
                echo '<li><strong>Bedrooms:</strong> ' . $row['num_bedrooms'] . '</li>';
                echo '<li><strong>Bathrooms:</strong> ' . $row['num_bathrooms'] . '</li>';
                echo '<li><strong>Garden:</strong> ' . ($row['has_garden'] ? 'Yes' : 'No') . '</li>';
                echo '<li><strong>Parking:</strong> ' . ($row['parking_availability'] ? 'Yes' : 'No') . '</li>';
                echo '<li><strong>Price:</strong> $' . $row['price'] . '</li>';
                echo '</ul>';
                echo '</div>';
            }
        }
        ?>
    </div>
    <?php
    // Close the database connection
    mysqli_close($conn);
    ?>
    <br>
    <h2>Add Property</h2>

    <div class="container">
        <form action="seller_dashboard.php" method="post">
            <div class="item">
                <label for="name">Name:</label><br>
                <input type="text" id="name" name="name" required><br>
            </div>
            <div class="item">
                <label for="location">Location:</label><br>
                <input type="text" id="location" name="location" required><br>
            </div>
            <div class="item">
                <label for="age">Age:</label><br>
                <input type="number" id="age" name="age" required><br>
            </div>
            <div class="item">
                <label for="square_footage">Square Footage:</label><br>
                <input type="number" id="square_footage" name="square_footage" required><br>
            </div>
            <div class="item">
                <label for="num_bedrooms">Number of Bedrooms:</label><br>
                <input type="number" id="num_bedrooms" name="num_bedrooms" required><br>
            </div>
            <div class="item">
                <label for="num_bathrooms">Number of Bathrooms:</label><br>
                <input type="number" id="num_bathrooms" name="num_bathrooms" required><br>
            </div>
            <div class="item">
                <label for="price">Price:</label><br>
                <input type="number" id="price" name="price" required><br><br>
            </div>
            <div class="item">
                <label for="image">Image URL:</label><br>
                <input type="text" id="image" name="image" required><br><br>
            </div><br>
            <div class="item">
                <label for="garden">Garden:</label><br>
                <input type="checkbox" id="garden" name="garden"><br>
            </div>
            <br>
            <div class="item">
                <label for="parking">Parking Availability:</label><br>
                <input type="checkbox" id="parking" name="parking"><br>
            </div>
    </div>
    <br>
    <input type="submit" name="submit" value="Add Property">
    </form>
    <br>
</body>

</html>