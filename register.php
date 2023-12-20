<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "game_store";

$username = "";
$birthdate = "";
$password = "";
$error_message = "";
require_once('validation_functions.php');
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $connect = mysqli_connect($host, $user, $password, $database);
} catch (mysqli_sql_exception $ex) {
    echo 'Помилка: ' . $ex->getMessage();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($connect, $_POST['username']);
    $birthdate = mysqli_real_escape_string($connect, $_POST['birthdate']);
    $password = mysqli_real_escape_string($connect, $_POST['password']);

    // Перевірка, чи існує вже користувач з таким ім'ям
    if (!validate_username($username)) {
        $error_message = "Invalid username. Use only letters and numbers.";
    } else {
        $checkQuery = "SELECT * FROM user WHERE Name = ?";
        $stmt = mysqli_prepare($connect, $checkQuery);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);

        $checkResult = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($checkResult) > 0) {
            $error_message = "Username already exists. Choose a different username.";
        } elseif (!validate_birthdate($birthdate)) {
            $error_message = "Invalid birthdate.";
        } elseif (!validate_password($password)) {
            $error_message = "Invalid password. Password must be at least 8 characters long.";
        } else {
            $insertQuery = "INSERT INTO user (Name, age, password) VALUES (?, ?, ?)";
            $insertStmt = mysqli_prepare($connect, $insertQuery);
            mysqli_stmt_bind_param($insertStmt, "sss", $username, $birthdate, $password);
            mysqli_stmt_execute($insertStmt);

            header("Location: login.php");
            exit();
    }
} 
}
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <title>Registration</title>
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

        input[type="date"] {
            width: calc(100% - 22px);
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
         small {
            display: none;
            color: #888;
        }
    </style>
</head>
<body>
    
    <form action="register.php" method="post">
        <h2>Registration</h2>
        <input type="text" name="username" placeholder="Username" required pattern="[a-zA-Z0-9]+"  title="Username must contain only English letters"><br><br>
        <input type="date" name="birthdate" required><br><br>
 <input type="password" name="password" id="password" placeholder="Password" required
           pattern="(?=.*\d).{8,}" title="Password must contain at least 8 characters and at least 1 digit"> <br><br>
        <input type="submit" value="Register">
         <p>Already have an account? <a href="login.php">Login here</a>.</p>
         <div class="error-message"><?php echo $error_message; ?></div>
             <div class="requirements">
        <h3>Password Requirements:</h3>
        <ul>
            <li>At least 8 characters long</li>
            <li>At least 1 digit</li>
        </ul>

        <h3>Username Requirements:</h3>
        <ul>
            <li>Only English letters and numbers</li>

        </ul>
    </div>
    </form>
   
</body>
</html>
