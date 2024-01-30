<?php
include('connection.php');

// Fetch order items from the database
$orderItemResult = $conn->query("SELECT * FROM order_item");

// Fetch search criteria from the URL
$searchColumn = isset($_GET['searchColumn']) ? $_GET['searchColumn'] : 'order_id';
$searchValue = isset($_GET['searchValue']) ? $_GET['searchValue'] : '';

// Check if the "Show All" button is clicked
if (isset($_GET['showAll'])) {
    // Reset search criteria
    $searchColumn = 'order_id';
    $searchValue = '';
}

// Fetch order items from the database based on search criteria
if (!empty($searchValue)) {
    $searchValue = $conn->real_escape_string($searchValue); // Protect against SQL injection
    $orderItemResult = $conn->query("SELECT * FROM order_item WHERE $searchColumn = '$searchValue'");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Items</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
        }

        h2 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: #fff;
        }

        a {
            display: inline-block;
            margin-top: 5px;
            margin-right: 10px;
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
            padding: 5px;
            border: 1px solid #007bff;
            border-radius: 3px;
        }

        a:hover {
            background-color: #007bff;
            color: #fff;
        }
    </style>
</head>

<body>
    <h2>Order Items</h2>

    <!-- Add search form -->
    <form action="" method="get">
        <label for="searchColumn">Search by:</label>
        <select name="searchColumn" id="searchColumn">
            <option value="order_item_id">Order Item ID</option>
            <option value="order_id">Order ID</option>
            <option value="quantity">Quantity</option>
            <option value="price">Price</option>
            <option value="product_id">Product ID</option>
            <!-- Add more options for other columns as needed -->
        </select>
        <input type="text" name="searchValue" placeholder="Enter value">
        <input type="submit" value="Search">
        <input type="submit" name="showAll" value="Show All">
    </form>

    <!-- Display order items in a table -->
    <table border="1">
        <tr>
            <th>Order Item ID</th>
            <th>Order ID</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Product ID</th>
            <!-- Add more columns as needed -->
            <th>Action</th>
        </tr>
        <?php
        while ($row = $orderItemResult->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['order_item_id']}</td>
                    <td>{$row['order_id']}</td>
                    <td>{$row['quantity']}</td>
                    <td>{$row['price']}</td>
                    <td>{$row['product_id']}</td>
                    <!-- Add more columns as needed -->
                    <td>
                        <a href='updateOrderItem.php?orderItemId={$row['order_item_id']}'>Update</a>
                        <a href='deleteOrderItem.php?orderItemId={$row['order_item_id']}'>Delete</a>
                    </td>
                  </tr>";
        }
        ?>
    </table>

    <!-- Add more HTML content or links for managing order items as needed -->

    <a href="admin.php">Back to Admin Panel</a>
</body>

</html>
