<?php
session_start();
$host = "localhost";
$user = "root";
$password = "";
$database = "game_store";

$order_id = "";
$order_name = "";
$user_id = "";
$error_message = "";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $connect = mysqli_connect($host, $user, $password, $database);
} catch (mysqli_sql_exception $ex) {
    echo 'Помилка: ' . $ex->getMessage();
}

// Function to insert an order
if (isset($_POST['Insert'])) {
    $order_name = $_POST['order_name'];
    $user_id = $_POST['user_id'];

  
    $checkUserQuery = "SELECT id FROM user WHERE id='$user_id'";
    $checkUserResult = mysqli_query($connect, $checkUserQuery);

    if (mysqli_num_rows($checkUserResult) > 0) {
       
        $query = "INSERT INTO orders (name, user_id) VALUES ('$order_name', '$user_id')";
        mysqli_query($connect, $query);
    } else {
      
        $error_message = "Помилка: Користувача з ID $user_id не існує.";
    }
}

// Function to update an order
if (isset($_POST['update'])) {
    $order_id = $_POST['order_id'];
    $order_name = $_POST['order_name'];
    $user_id = $_POST['user_id'];

    $query = "UPDATE orders SET name='$order_name', user_id='$user_id' WHERE id='$order_id'";
    mysqli_query($connect, $query);
}

// Function to delete an order
if (isset($_POST['delete'])) {
    $order_id = $_POST['order_id'];

    $query = "DELETE FROM orders WHERE id='$order_id'";
    mysqli_query($connect, $query);
}

// Function to search for an order
if (isset($_POST['search'])) {
    $order_id = $_POST['order_id'];

    $query = "SELECT * FROM orders WHERE id='$order_id'";
    $result = mysqli_query($connect, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $order_id = $row['id'];
        $order_name = $row['name'];
        $user_id = $row['user_id'];
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
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
<h2>Orders</h2>

<div class="error-message"><?php echo $error_message; ?></div>

<div class="user-info">
    <p>Hello, <?php echo $_SESSION['username']; ?> (ID: <?php echo $_SESSION['user_id']; ?>)</p>
    <a href="login.php?logout=1">Logout</a>
</div>

<div>
    <?php
    // Display all orders
    $allOrdersQuery = "SELECT * FROM orders";
    $allOrdersResult = mysqli_query($connect, $allOrdersQuery);

    if ($allOrdersResult) {
        echo "<h2>All Orders:</h2>";
        echo "<table border='1'>
                <tr>
                    <th>Order ID</th>
                    <th>Order Name</th>
                    <th>User ID</th>
                </tr>";

        while ($row = mysqli_fetch_assoc($allOrdersResult)) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['user_id']}</td>
                </tr>";
        }

        echo "</table>";
    } else {
        echo "Error retrieving orders: " . mysqli_error($connect);
    }
    ?>
</div>

<form action="orders.php" method="post">
    <input type="number" name="order_id" placeholder="Order ID" value="<?php echo $order_id; ?>"><br><br>
    <input type="text" name="order_name" placeholder="Order Name" value="<?php echo $order_name; ?>"><br><br>
    <input type="number" name="user_id" placeholder="User ID" value="<?php echo $user_id; ?>"><br><br>
    <div>
        <input type="submit" name="Insert" value="Add">
        <input type="submit" name="update" value="Update">
        <input type="submit" name="delete" value="Delete">
        <input type="submit" name="search" value="Find">
    </div>
</form>

<?php
// Display search results
if (isset($_POST['search']) && isset($order_id) && $order_id != "") {
    echo "<h2>Знайдено об'єкт:</h2>";
    echo "<table border='1'>
            <tr>
                <th>Order ID</th>
                <th>Order Name</th>
                <th>User ID</th>
            </tr>
            <tr>
                <td>{$order_id}</td>
                <td>{$order_name}</td>
                <td>{$user_id}</td>
            </tr>
          </table>";
}
?>
<br>
<a href="comments.php"><button>Go to Comments</button></a>
<a href="product.php"><button>Go to Products</button></a>
</body>
</html>
