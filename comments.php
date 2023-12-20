<?php
session_start();
$host = "localhost";
$user = "root";
$password = "";
$database = "game_store";

$id = "";
$product_id = "";
$user_id = "";
$grade = "";
$text = "";
$error_message = "";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $connect = mysqli_connect($host, $user, $password, $database);
} catch (mysqli_sql_exception $ex) {
    echo 'Помилка: ' . $ex->getMessage();
}

// Function to insert a comment
if (isset($_POST['Insert'])) {
    $product_id = $_POST['product_id'];
    $user_id = $_POST['user_id'];
    $grade = $_POST['grade'];
    $text = $_POST['text'];

    if ($product_id != '' && $user_id != '' && $grade != '' && $text != '') {
        $query = "INSERT INTO comments (product_id, user_id, grade, text) VALUES ('$product_id', '$user_id', '$grade', '$text')";
        mysqli_query($connect, $query);
    } else {
        $error_message = "Усі поля повинні бути заповнені";
    }
}

// Function to update a comment
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $product_id = $_POST['product_id'];
    $user_id = $_POST['user_id'];
    $grade = $_POST['grade'];
    $text = $_POST['text'];

    if ($id != '' && $product_id != '' && $user_id != '' && $grade != '' && $text != '') {
        $query = "UPDATE comments SET product_id='$product_id', user_id='$user_id', grade='$grade', text='$text' WHERE id='$id'";
        mysqli_query($connect, $query);
    } else {
        $error_message = "Усі поля повинні бути заповнені";
    }
}

// Function to delete a comment
if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    if ($id != '') {
        $query = "DELETE FROM comments WHERE id='$id'";
        mysqli_query($connect, $query);
    } else {
        $error_message = "Введіть ID коментаря для видалення";
    }
}

// Function to search for a comment
if (isset($_POST['search'])) {
    $id = $_POST['id'];

    if ($id != '') {
        $query = "SELECT * FROM comments WHERE id='$id'";
        $result = mysqli_query($connect, $query);

        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $product_id = $row['product_id'];
            $user_id = $row['user_id'];
            $grade = $row['grade'];
            $text = $row['text'];
        }
    } else {
        $error_message = "Введіть ID коментаря для пошуку";
    }
}
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <title>PHP INSERT UPDATE DELETE SEARCH</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .user-info {
            text-align: center;
            margin-right: 20px;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            margin-top: 20px;
        }

        input[type="number"],
        input[type="text"] {
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

        .table-container {
            width: 60%;
            margin:0 auto;
            overflow-y: auto; 
            max-height: 400px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }

        button {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 20px;
            text-decoration: none;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<h2>Comments</h2>

<div class="error-message"><?php echo $error_message; ?></div>

<div class="user-info">
    <p>Hello, <?php echo $_SESSION['username']; ?> (ID: <?php echo $_SESSION['user_id']; ?>)</p>
    <a href="login.php?logout=1">Logout</a>
</div>

<div class="table-container">
    <?php
    // Display all comments
    $allCommentsQuery = "SELECT * FROM comments";
    $allCommentsResult = mysqli_query($connect, $allCommentsQuery);

    if ($allCommentsResult) {
        echo "<h2>All Comments:</h2>";
        echo "<table border='1'>
                <tr>
                    <th>ID</th>
                    <th>Product ID</th>
                    <th>User ID</th>
                    <th>Grade</th>
                    <th>Comment</th>
                </tr>";

        while ($row = mysqli_fetch_assoc($allCommentsResult)) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['product_id']}</td>
                    <td>{$row['user_id']}</td>
                    <td>{$row['grade']}</td>
                    <td>{$row['text']}</td>
                </tr>";
        }

        echo "</table>";
    } else {
        echo "Error retrieving comments: " . mysqli_error($connect);
    }
    ?>
</div>

<form action="comments.php" method="post">
    <input type="number" name="id" placeholder="Id" value="<?php echo $id; ?>"><br><br>
    <input type="number" name="product_id" placeholder="Product ID" value="<?php echo $product_id; ?>"><br><br>
    <input type="number" name="user_id" placeholder="User ID" value="<?php echo $user_id; ?>"><br><br>
    <input type="number" name="grade" placeholder="Grade" value="<?php echo $grade; ?>"><br><br>
    <input type="text" name="text" placeholder="Comment" value="<?php echo $text; ?>"><br><br>
    <div>
        <input type="submit" name="Insert" value="Add">
        <input type="submit" name="update" value="Update">
        <input type="submit" name="delete" value="Delete">
        <input type="submit" name="search" value="Find">
    </div>
</form>

<?php
// Display search results
if (isset($_POST['search']) && isset($id) && $id != "") {
    echo "<h2>Знайдено об'єкт:</h2>";
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Product ID</th>
                <th>User ID</th>
                <th>Grade</th>
                <th>Comment</th>
            </tr>
            <tr>
                <td>{$id}</td>
                <td>{$product_id}</td>
                <td>{$user_id}</td>
                <td>{$grade}</td>
                <td>{$text}</td>
            </tr>
          </table>";
}
?>
<br>
<a href="product.php"><button>Go to Product</button></a>
<a href="orders.php"><button>Go to Orders</button></a>
</body>
</html>
