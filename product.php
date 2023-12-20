<?php
session_start();

$host = "localhost";
$user = "root";
$password = "";
$database = "game_store";

$product_id = "";
$product_name = "";
$genre = "";
$price = "";
$order_id = "";
$error_message = "";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $connect = mysqli_connect($host, $user, $password, $database);
} catch (mysqli_sql_exception $ex) {
    echo 'Помилка: ' . $ex->getMessage();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Logout functionality
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

// Function to insert a product
if (isset($_POST['Insert'])) {
    $product_name = $_POST['product_name'];
    $genre = $_POST['genre'];
    $price = $_POST['price'];
    $order_id = $_POST['order_id'];

    
    if (empty($product_name) || empty($genre) || empty($price) || empty($order_id)) {
        $error_message = "Помилка додавання продукта: Усі поля повинні бути заповненно";
    } else {
        $query = "INSERT INTO product (Name, ganre, price, id_orders) VALUES ('$product_name', '$genre', '$price', '$order_id')";
        if (mysqli_query($connect, $query)) {
            // Product inserted successfully
        } else {
            $error_message = "Error inserting product: " . mysqli_error($connect);
        }
    }
}

// Function to update a product
if (isset($_POST['update'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $genre = $_POST['genre'];
    $price = $_POST['price'];
    $order_id = $_POST['order_id'];

  
    if (empty($product_name)) {
        $error_message = "Помилка обновлення продукту: Поле з назвою продукту повинно бути заповненно";
    } else {
        $query = "UPDATE product SET Name='$product_name', ganre='$genre', price='$price', id_orders='$order_id' WHERE id='$product_id'";
        if (mysqli_query($connect, $query)) {
            // Product updated successfully
        } else {
            $error_message = "Error updating product: " . mysqli_error($connect);
        }
    }
}

// Function to delete a product
if (isset($_POST['delete'])) {
    $product_id = $_POST['product_id'];

   
    if (empty($product_id)) {
        $error_message = "Помикла Видалення: оберіть об'єкт для видалення";
    } else {
        $query = "DELETE FROM product WHERE id='$product_id'";
        if (mysqli_query($connect, $query)) {
            // Product deleted successfully
        } else {
            $error_message = "Error deleting product: " . mysqli_error($connect);
        }
    }
}

// Function to search for a product
if (isset($_POST['search'])) {
    $product_id = $_POST['product_id'];

    $query = "SELECT * FROM product WHERE id='$product_id'";
    $result = mysqli_query($connect, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $product_id = $row['id'];
        $product_name = $row['Name'];
        $genre = $row['ganre'];
        $price = $row['price'];
        $order_id = $row['id_orders'];
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
    min-height: 100vh; 
    overflow-y: auto; 
}

        h2 {
            text-align: center;
            color: #333;
        }

        .user-info {
            text-align: center;
            margin-right: 20px;
        }

        p {
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
            width: 60%;
            margin:0 auto;
            overflow-y: auto; 
            max-height: 400px;
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
    <h2>Products</h2>

   <div class="user-info">
   
    <p>Hello, <?php echo $_SESSION['username']; ?> (ID: <?php echo $_SESSION['user_id']; ?>)</p>


    <a href="login.php?logout=1">Logout</a>
</div>

    <div class="error-message"><?php echo $error_message; ?></div>

    <?php
    $allProductsQuery = "SELECT * FROM product";
    $allProductsResult = mysqli_query($connect, $allProductsQuery);

    if ($allProductsResult) {
        echo "<h2>All Products:</h2>";
        echo "<table border='1'>
                <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Genre</th>
                    <th>Price</th>
                </tr>";

        while ($row = mysqli_fetch_assoc($allProductsResult)) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['Name']}</td>
                    <td>{$row['ganre']}</td>
                    <td>{$row['price']}</td>
                </tr>";
        }

        echo "</table>";
    } else {
        echo "Error retrieving products: " . mysqli_error($connect);
    }
    ?>

    <form action="product.php" method="post">
        <input type="number" name="product_id" placeholder="Product ID" value="<?php echo $product_id; ?>"><br><br>
        <input type="text" name="product_name" placeholder="Product Name" value="<?php echo $product_name; ?>"><br><br>
        <input type="text" name="genre" placeholder="Genre" value="<?php echo $genre; ?>"><br><br>
        <input type="number" name="price" placeholder="Price" value="<?php echo $price; ?>"><br><br>
        <input type="number" name="order_id" placeholder="Order ID" value="<?php echo $order_id; ?>"><br><br>
        <div>
            <input type="submit" name="Insert" value="Add">
            <input type="submit" name="update" value="Update">
            <input type="submit" name="delete" value="Delete">
            <input type="submit" name="search" value="Find">
        </div>
    </form>

    <?php
    if (isset($_POST['search']) && isset($product_id) && $product_id != "") {
        echo "<h2>Знайдено об'єкт:</h2>";
        echo "<table border='1'>
                <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Genre</th>
                    <th>Price</th>
                </tr>
                <tr>
                    <td>{$product_id}</td>
                    <td>{$product_name}</td>
                    <td>{$genre}</td>
                    <td>{$price}</td>
                </tr>
              </table>";
    }
    ?>
    <br>
    <a href="comments.php"><button>Go to Comments</button></a>
    <a href="orders.php"><button>Go to Orders</button></a>
</body>
</html>
