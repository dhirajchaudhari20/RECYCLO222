<?php
// Database connection parameters
$host = 'localhost';
$dbname = 'patient';
$username = 'root';
$password = '';

// Establishing a connection to the database
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Function to sanitize input data
function sanitizeInput($data) {
    return htmlspecialchars(strip_tags($data));
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user data from the form
    $fullName = sanitizeInput($_POST['full_name']);
    $email = sanitizeInput($_POST['email']);
    $mobileNumber = sanitizeInput($_POST['mobile_number']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hashing the password

    // Insert user data into the "patients" table
    $sql = "INSERT INTO patients (full_name, email, mobile_number, password) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([$fullName, $email, $mobileNumber, $password]);
        echo "User data inserted successfully!";
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register User - RECYCLO</title>
    <link rel="stylesheet" href="../vendor/formstyle.css">
</head>
<body>
    <div class="login-page">
        <div class="backbtn">
            <button><a href="../index.html"><h3>Home page</h3></a></button>
        </div>
        <form class="container" action="register.php" method="post">
            <div class="input-box">
                <caption><b>This is the registration page. Please register to RECYCLO.</b></caption>
                <h1><span>Register</span></h1>
                <input type="text" placeholder="Full Name" name="full_name" required><br> 
                <input type="text" placeholder="Your Mobile Number" name="mobile_number"><br>
                <input type="email" placeholder="Email" name="email" required><br>
                <input type="password" placeholder="Password" name="password" required><br>
                <button type="submit">Register</button>
            </div>
        </form>
        <div class="remember-forget">
            <label><a href="../templates/helppage.html">Need Help?</a></label>
        </div>
    </div>
</body>
</html>
