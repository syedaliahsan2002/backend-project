<?php
include('connection.php');

// Fetch all orders from the database
$orderResult = $conn->query("SELECT * FROM `order`");

// Fetch search criteria from the URL
$searchColumn = isset($_GET['searchColumn']) ? $_GET['searchColumn'] : 'rider_id';
$searchValue = isset($_GET['searchValue']) ? $_GET['searchValue'] : '';

// Check if the "Show All" button is clicked
if (isset($_GET['showAll'])) {
    // Reset search criteria
    $searchColumn = 'rider_id';
    $searchValue = '';
}

// Fetch orders from the database based on search criteria
if (!empty($searchValue)) {
    $searchValue = $conn->real_escape_string($searchValue); // Protect against SQL injection
    $orderResult = $conn->query("SELECT * FROM `order` WHERE $searchColumn = '$searchValue'");
}

// Fetch all rows into an array
$rows = [];
while ($row = $orderResult->fetch_assoc()) {
    $rows[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
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

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: #fff;
        }

        a {
            display: block;
            margin-top: 20px;
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h2>Orders</h2>

    <!-- Add search form -->
    <form action="" method="get">
        <label for="searchColumn">Search by:</label>
        <select name="searchColumn" id="searchColumn">
            <option value="order_id">Order ID</option>
            <option value="order_date">Order Date</option>
            <option value="payment_method">Payment Method</option>
            <option value="rider_id">Rider ID</option>
            <!-- Add more options for other columns as needed -->
        </select>
        <input type="text" name="searchValue" placeholder="Enter value">
        <input type="submit" value="Search">
        <input type="submit" name="showAll" value="Show All">
    </form>

    <!-- Display orders in a table -->
    <table border="1">
        <tr>
            <th>Order ID</th>
            <th>Order Date</th>
            <th>Payment Method</th>
            <th>Rider ID</th>
            <!-- Add more columns as needed -->
        </tr>
        <?php
        foreach ($rows as $row) {
            echo "<tr>
                    <td>{$row['order_id']}</td>
                    <td>{$row['order_date']}</td>
                    <td>{$row['payment_method']}</td>
                    <td>{$row['rider_id']}</td>
                    <!-- Add more columns as needed -->
                  </tr>";
        }
        ?>
    </table>

    <!-- Add more HTML content or links for managing orders as needed -->

    <a href="admin.php">Back to Admin Panel</a>
</body>

</html>
