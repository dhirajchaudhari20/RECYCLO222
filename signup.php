
<?php
session_start();
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
    $username = sanitizeInput($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hashing the password

    // Insert user data into the "patients" table
    $sql = "INSERT INTO patients (full_name, email, username, password) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([$fullName, $email, $username, $password]);
        // Output success message
        echo "User data inserted successfully!";
        // Refresh the page after 2 seconds
  
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
    <link rel="stylesheet" href="formstyle.css">
</head>
<style>
    </style>
<body>
    <div class="login-page">
        <div class="backbtn">
         
        </div>
        <style>
            *{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}
body{
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    min-width: 70rlh;
    background: url(web_bg2.jpg) no-repeat;
    background-size: cover;
    background-position: center;
    position: absolute;
    background-attachment: fixed;
}
.wrapper{
    width: 420px;
    background: transparent;
    border:2px solid rgba(195, 20, 20, 0.2);
    backdrop-filter: blur(20px);
    box-shadow: 0 0 10px rgba(0, 0, 0, .2);
    color: #fff;
    border-radius: 10px;
    padding: 30px 40px;
}
.wrapper h1{
    font-size: 36px;
    text-align: center;
}
.wrapper .input-box{
    width: 100%;
    height: 60px;
    position: relative;
    margin-top: 20px;
}
.input-box input{
    width: 100%;
    height: 100%;
    background: transparent;
    border: none;
    outline: none;
    border: 2px solid rgba(255, 255, 255, .2);
    border-radius: 40px;
    font-size: 16px;
    color: #fff;
    padding: 20px 40px 20px 20px;
}
.input-box input::placeholder{
    color: #fff;

}
.wrapper .remember-forget{
    display: flex;
    justify-content: space-between;
    font-size: 14.5px;
    margin: 15px 5px 15px;
}
.remember-forgot label input{
accent-color: #fff;
margin-right: 3px;
}
.remember-forget a {
    color: #fff;
    text-decoration: none;
}
.remember-forget a:hover{
    text-decoration: underline;
    color: red;
}
.wrapper .btn{
    width: 100%;
    height: 45px;
    background: #fff;
    border: none;
    outline: none;
    border-radius: 40px;
    box-shadow: 0 0 10px rgba(0, 0, 0, .1);
    cursor: pointer;
    color: #333;
    font-weight: 700;
}
.wrapper .register-link{
    font-size: 14.5px;
    text-align: center;
    margin: 20px 0 15px;

}
.register-link p a{
    color: #fff;
    text-decoration: none;
    font-weight: 600;
}
.register-link p a:hover{
    text-decoration: underline;
    color: blue;
}
.login-page{
    width: 420px;
    background: transparent;
    border:2px solid rgba(195, 20, 20, 0.2);
    backdrop-filter: blur(20px);
    box-shadow: 0 0 10px rgba(0, 0, 0, .2);
    color: #fff;
    border-radius: 10px;
    padding: 30px 40px;
}
.login-page .input-box .checklist .btn{
    width: 100%;
    height: 45px;
    background: transparent;
    border: none;
    outline: none;
    border-radius: 40px;
    box-shadow: 0 0 10px rgba(0, 0, 0, .1);
    cursor: pointer;
    color: #fff;
    font-weight: 700;
}
.login-page .input-box .checklist .remeber-forget{
    color: burlywood;
    font-size: 20px;
}
.col-md-4 .form-select{
    width: 80%;
    height: 45px;
    justify-content: center;
    background: transparent;
    border: none;
    outline: none;
    border-radius: 40px;
    box-shadow: 0 0 10px rgba(0, 0, 0, .1);
    color: #333;
    font-weight: 700;
}
.login-page .input-box .btn{
    width: 100%;
    height: 45px;
    background: transparent;
    border: none;
    outline: none;
    border-radius: 40px;
    box-shadow: 0 0 10px rgba(0, 0, 0, .1);
    cursor: pointer;
    color: #fff;
    font-weight: 700;
}
.login-page .input-box #placeholder{
    color: #fff;
}
.backbtn{
    padding: 10px 5px;
    width: 300px;
    height: 30px;
    opacity: 0.66;
    margin-top: 20px;
    margin-left: 600px;
}
.backbtn a{
    color: rgb(19, 72, 158);
}

input{
    margin-top: 5px;
}

input:hover{
    border: 1px solid white;
}

.form-label{
    font-size: 1rem;
    font-weight: 700;
}
    </style>
        <form class="container" action="" method="post">
            <div class="input-box">
                <caption><b>This is the registration page. Please register to RECYCLO.</b></caption>
                <h1><span>Register</span></h1>
                <input type="text" placeholder="Full Name" name="full_name" required><br> 
                <input type="email" placeholder="Email" name="email" required><br>
                <input type="text" placeholder="Username" name="username" required><br>
                <input type="password" placeholder="Password" name="password" required><br>
                <button type="submit" class="btn">Register</button>
            </div>
        </form>
        <div class="remember-forget">
        <input type="button" value="Back to Home" onclick="redirecthome()">
        <script>
    function redirecthome() {
    // Redirect to index.php
    window.location.href = 'index.php';
}
    </script>
    <div class="login-link">
        <p>Done with signup? <a href="login.php">Login now</a></p>
    </div>
            <label><a href="../templates/helppage.html">Need Help?</a></label>
        </div>
    </div>
</body>
</html>
