
<?php
session_start();

// Database connection parameters
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'patient';

// Establishing a connection to the database
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user data from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the entered username and password match the database
    $stmt = $pdo->prepare("SELECT * FROM patients WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Login successful, store user data in session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_username'] = $user['username'];

        // Redirect to dashboard.php
        header("Location: dashboard.php");
        exit();
    } else {
        // Login failed, display an error message
        $loginError = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="../vendor/formstyle.css">
</head>
<body>
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
    <div class="wrapper">
        <form method="post" action="">
            <h1>Login</h1>
            <div class="input-box">
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="input-box">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <div class="remember-forgot">
                <label>
                    <input type="checkbox">Remember me
                </label>
                <a href="#">Forgot password ?</a>
            </div>
            
            <?php if (isset($loginError)) : ?>
                <div class="error"><?php echo $loginError; ?></div>
            <?php endif; ?>
            <input type="submit" value="Login">

            <div class="register-link">
                <p>Don't have an account?<a href="signup.php">Register</a></p>
            </div>
        </form>
    </div>
</body>
</html>
