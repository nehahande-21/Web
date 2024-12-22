<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registration_db"; // Database name

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname, 3307);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form data when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize user input
    $name = $conn->real_escape_string(trim($_POST['name']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $phone = $conn->real_escape_string(trim($_POST['phone']));
    $gender = $conn->real_escape_string(trim($_POST['gender']));
    $password = $conn->real_escape_string(trim($_POST['password']));
    $dob = $conn->real_escape_string(trim($_POST['dob']));

    // Validate required fields
    if (empty($name) || empty($email) || empty($phone) || empty($gender) || empty($password) || empty($dob)) {
        die("All fields are required.");
    }

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare SQL query to insert data into the database
    $sql = "INSERT INTO users (name, email, phone, gender, password, dob) 
            VALUES ('$name', '$email', '$phone', '$gender', '$hashedPassword', '$dob')";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green;'>Registration successful! 😊</p>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
