<?php
session_start();

$host = "localhost";
$user = "root";
$password = "";
$database = "game_store";

$username = "";
$password = "";
$error_message = "";

$max_attempts = 3; 
$lockout_duration = 30; 

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $connect = mysqli_connect($host, $user, $password, $database);
} catch (mysqli_sql_exception $ex) {
    echo 'Помилка: ' . $ex->getMessage();
}

// Підключення файла з функціями валідації і очистки
require_once('validation_functions.php');

// Check if the account is locked due to too many failed attempts
if (isset($_SESSION['lockout_time']) && time() - $_SESSION['lockout_time'] < $lockout_duration) {
    $error_message = "Account locked. Please try again later.";
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = sanitize_input($_POST['username']); // Використовуэмо функцію очистки
    $password = sanitize_input($_POST['password']);

    if (!validate_username($username)) {
        $error_message = "Invalid username format.";
    } else {
        $query = "SELECT * FROM user WHERE Name = ?";
        $stmt = mysqli_prepare($connect, $query);
        mysqli_stmt_bind_param($stmt, "s", $username); 
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            $user = mysqli_fetch_assoc($result);
            if ($user && $password === $user['password']) {
                // Reset the login attempts on successful login
                $_SESSION['login_attempts'] = 0;

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['Name'];

                header("Location: product.php");
                exit();
            } else {
                // Increment the login attempts
                $_SESSION['login_attempts'] = isset($_SESSION['login_attempts']) ? $_SESSION['login_attempts'] + 1 : 1;

                if ($_SESSION['login_attempts'] >= $max_attempts) {
                    // Lock the account and set the lockout time
                    $_SESSION['lockout_time'] = time();
                    $error_message = "Too many failed login attempts. Account locked. Please try again later.";
                } else {
                    $error_message = "Invalid username or password";
                }
            }
        } else {
            $error_message = "Error in database query";
        }
    }
}
?>


<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        p {
            text-align: center;
            margin-top: 10px;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
                .error-message {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <form action="login.php" method="post">
        <h2>Login</h2>
        <input type="text" name="username" placeholder="Username" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <input type="submit" value="Login">
        <p>Don't have an account? <a href="register.php">Register here</a>.</p>
        <div class="error-message"><?php echo $error_message; ?></div>
    </form>
</body>
</html>
