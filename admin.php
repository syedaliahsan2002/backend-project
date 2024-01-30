<!-- admin.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        header {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px;
        }

        h1 {
            color: white;
        }

        nav {
            display: flex;
            justify-content: center;
            background-color: #eee;
            padding: 10px;
        }

        nav a {
            margin: 0 15px;
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }

        nav a:hover {
            color: #007bff;
        }
    </style>
</head>

<body>
    <header>
        <h1>Welcome to the Admin Panel</h1>
    </header>

    <nav>
        <!-- Add links to handle product, rider, order, and order_item operations -->
        <a href="product.php">Manage Products</a>
        <a href="rider.php">Manage Riders</a>
        <a href="order.php">Manage Orders</a>
        <a href="order_item.php">Manage Order Items</a>
        <a href="home.php">Home</a>
    </nav>
</body>

</html>
