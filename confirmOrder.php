<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #333;
            color: white;
            padding: 10px;
            text-align: center;
        }

        section {
            padding: 20px;
            background-color: #fff;
            margin: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        a {
            display: inline-block;
            margin: 20px;
            padding: 10px 20px;
            background-color: #333;
            color: white;
            text-decoration: none;
        }

        .print-button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 20px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<header>
    <h1>Order Confirmation</h1>
</header>

<section>
    <?php
    session_start();
    include('connection.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $phone_number = $_POST['phone_number'];
        $address = $_POST['address'];
        $country = $_POST['country'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $postal_code = $_POST['postal_code'];
        $payment_method = $_POST['payment_method'];

        $stmtCustomer = $conn->prepare("INSERT INTO customer (username, email, password, phone_number, address, country, city, state, postal_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmtCustomer->bind_param("sssssssss", $username, $email, $password, $phone_number, $address, $country, $city, $state, $postal_code);

        if ($stmtCustomer->execute()) {
            $customer_id = $stmtCustomer->insert_id;

            if (isset($_SESSION['cartItems']) && is_array($_SESSION['cartItems'])) {
                $stmtAvailableRider = $conn->prepare("SELECT rider_id, rider_name, rider_phone FROM rider WHERE is_available = 1 ORDER BY RAND() LIMIT 1");

                if ($stmtAvailableRider) {
                    if ($stmtAvailableRider->execute()) {
                        $stmtAvailableRider->store_result();

                        if ($stmtAvailableRider->num_rows > 0 && $stmtAvailableRider->bind_result($rider_id, $rider_name, $rider_phone) && $stmtAvailableRider->fetch()) {
                            if ($rider_id !== null) {
                                $stmtUpdateRider = $conn->prepare("UPDATE rider SET is_available = 0 WHERE rider_id = ?");
                                $stmtUpdateRider->bind_param("i", $rider_id);

                                if ($stmtUpdateRider->execute()) {
                                    $order_date = date('Y-m-d');
                                    $stmtOrder = $conn->prepare("INSERT INTO `order` (customer_id, order_date, payment_method, rider_id) VALUES (?, ?, ?, ?)");
                                    $stmtOrder->bind_param("issi", $customer_id, $order_date, $payment_method, $rider_id);

                                    if ($stmtOrder->execute()) {
                                        $lastOrderId = $stmtOrder->insert_id;

                                        foreach ($_SESSION['cartItems'] as $itemName => $itemDetails) {
                                            $productResult = $conn->query("SELECT product_id FROM product WHERE name = '$itemName'");

                                            if ($productResult) {
                                                if ($productRow = $productResult->fetch_assoc()) {
                                                    $productId = $productRow['product_id'];
                                                    $quantity = $itemDetails['quantity'];
                                                    $price = $itemDetails['price'];

                                                    $stmtOrderItem = $conn->prepare("INSERT INTO order_item (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
                                                    $stmtOrderItem->bind_param("iiid", $lastOrderId, $productId, $quantity, $price);

                                                    if ($stmtOrderItem->execute()) {
                                                        echo 'Order item for ' . $itemName . ' confirmed successfully!<br>';
                                                    } else {
                                                        echo 'Error inserting order item for ' . $itemName . ': ' . $stmtOrderItem->error . '<br>';
                                                    }

                                                    $stmtOrderItem->close();
                                                } else {
                                                    echo 'No product details found for ' . $itemName . '<br>';
                                                }
                                            } else {
                                                echo 'Error fetching product details for ' . $itemName . ': ' . $conn->error . '<br>';
                                            }
                                        }

                                        echo 'Order confirmed successfully!<br>';
                                        echo 'Your rider details:<br>';
                                        echo 'Rider ID: ' . $rider_id . '<br>';
                                        echo 'Rider Name: ' . $rider_name . '<br>';
                                        echo 'Rider Phone: ' . $rider_phone . '<br>';
                                        echo 'Order ID: ' . $lastOrderId . '<br>';
                                    } else {
                                        echo 'Error processing the order: ' . $stmtOrder->error . '<br>';
                                    }

                                    $stmtOrder->close();
                                } else {
                                    echo 'Error updating rider availability: ' . $stmtUpdateRider->error . '<br>';
                                }

                                $stmtUpdateRider->close();
                            } else {
                                echo 'No available rider please try again later.<br>';
                            }
                        } else {
                            echo 'No available rider please try again later.<br>';
                        }
                    } else {
                        echo 'Error executing rider query: ' . $stmtAvailableRider->error . '<br>';
                    }

                    $stmtAvailableRider->close();
                } else {
                    echo 'Error preparing rider statement: ' . $conn->error . '<br>';
                }
            } else {
                echo 'No cart items found or cart items are not an array.<br>';
            }

            $stmtCustomer->close();
        } else {
            echo 'Invalid request.<br>';
        }
    }
    ?>
</section>

<a href="#" class="print-button" onclick="window.print()">Print This</a>
<a href="home.php">Back to Shopping</a>

</body>
</html>
