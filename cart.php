<?php
session_start();

// Check if the cart items are stored in the session
$cartItems = isset($_SESSION['cartItems']) && is_array($_SESSION['cartItems']) ? $_SESSION['cartItems'] : array();

// Check if a product is being removed
if (isset($_GET['remove'])) {
    $removeItem = $_GET['remove'];
    if (isset($cartItems[$removeItem])) {
        unset($cartItems[$removeItem]);
        $_SESSION['cartItems'] = $cartItems;

        // Check if the cart is empty after removing the item
        if (empty($cartItems)) {
            session_destroy(); // Destroy the entire session
        }

        header("Location: cart.php"); // Redirect to update the page
        exit();
    }
}

// Check if the quantity is being updated
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateQuantity'])) {
    $updateItem = $_POST['updateQuantity']['item'];
    $newQuantity = $_POST['updateQuantity']['quantity'];

    if (isset($cartItems[$updateItem])) {
        $cartItems[$updateItem]['quantity'] = $newQuantity;
        $_SESSION['cartItems'] = $cartItems;
        echo json_encode(['success' => true]); // Send JSON response
        exit(); // Stop further execution
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color:lightpink;
        }

        header {
            background-color: #333;
            color: white;
            padding: 10px;
            text-align: center;
        }

        nav {
            background-color: #444;
            color: white;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
        }

        .cart-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .cart-item {
            border: 1px solid #ddd;
            padding: 10px;
            margin: 10px;
            width: 200px;
            text-align: center;
            box-shadow:10px 10px 10px rgba(0,0,0,0.3);
            border-radius:20px;
            background-attachment: fixed;
            background-color:#fff;
            transition:all 0.3s ease;
        }
        .cart-item:hover{
            box-shadow:14px 14px 25px rgba(0,0,0,0.5);

        }
        .quantity-input {
            width: 40px;
        }

        .subtotal {
            margin-top: 20px;
            text-align: right;
        }

        .grand-subtotal {
            font-size: 1.2em;
            font-weight: bold;
            text-align: center;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .confirm-order-btn {
            background-color: #4caf50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom:30px;

        }

        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px;
        }

        /* Styles for the modal */
        .modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background-color: #fff;
            box-shadow: 10px 10px 10px rgba(0, 0, 0, 0.2);
            z-index: 1000;
        }

        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        /* Add the following style to prevent scrolling when the modal is open */
        body.modal-open {
            overflow: hidden;
        }
    </style>
</head>
<body>

<nav>
    <a href="home.php">Home</a>
    <div>Cart <span id="cartItemCount"><?php echo count($cartItems); ?></span></div>
</nav>

<section>
   <center> <h2>Your Cart</h2></center>

    <div class="cart-container">
        <?php
        // Display cart items
        foreach ($cartItems as $itemName => $itemDetails) {
            echo "<div class='cart-item'>
                    <img src='{$itemDetails['image']}' alt='{$itemName}' style='width: 100px; height: 100px;'>
                    <h3>{$itemName}</h3>
                    <p>Price: {$itemDetails['price']}</p>
                    <label for='quantity{$itemName}'>Quantity:</label>
                    <input class='qut' type='number' class='quantity-input' id='quantity{$itemName}' value='{$itemDetails['quantity']}'>
                    <button class='button' onclick='updateQuantity(\"{$itemName}\")'>Update Quantity</button>
                    <p>Subtotal: " . $itemDetails['price'] * $itemDetails['quantity'] . "</p>
                    <a class='button1' href='cart.php?remove={$itemName}'>Remove</a>
                </div>";
        }
        ?>
    </div>
<style>
    .qut{
        border:0px;
        width:30px
    }
    .button1 {
  color: red;
  text-decoration: none;
  font-size: 25px;
  border: none;
  background: none;
  font-weight: 600;
  font-family: 'Poppins', sans-serif;
}

.button1::before {
  margin-left: auto;
}

.button1::after, .button1::before {
  content: '';
  width: 0%;
  height: 2px;
  background: #f44336;
  display: block;
  transition: 0.5s;
}

.button1:hover::after, .button1:hover::before {
  width: 100%;
}
    .button {
  position: relative;
  background-color: rgb(230, 34, 77);
  border-radius: 5px;
  box-shadow: rgb(121, 18, 55) 0px 4px 0px 0px;
  padding: 15px;
  background-repeat: no-repeat;
  box-sizing: border-box;
  width: 154px;
  height: 49px;
  color: #fff;
  border: none;
  font-size: 14px;
  transition: all .3s ease-in-out;
  z-index: 1;
  overflow: hidden;
}

.button::before {
  content: "";
  background-color: rgb(248, 50, 93);
  width: 0;
  height: 100%;
  position: absolute;
  top: 0;
  left: 0;
  z-index: -1;
  transition: width 700ms ease-in-out;
  display: inline-block;
}

.button:hover::before {
  width: 100%;
}
</style>
    <!-- Calculate subtotal -->
    <?php
    $subtotal = array_sum(array_map(function ($item) {
        return $item['price'] * $item['quantity'];
    }, $cartItems));
    // echo "<div class='subtotal'>Subtotal: $subtotal</div>";
    ?>

    <!-- Display grand subtotal -->
<div class="grand-subtotal">Grand Subtotal: <?php echo $subtotal; ?></div>

    <!-- Add this button at the end of your <section> in cart.php -->
 <center>   <button class="confirm-order-btn" onclick="openOrderForm()">Confirm Order</button></center>
</section>

<!-- Your existing scripts here -->

<footer>
    <p>© 1991 - 2023. All Rights Reserved. No Part Of This Website May Be Reproduced, Stored In A Retrieval System, Or Transmitted In Any Form By Any Means, Electronic, Mechanical, Or Otherwise, Without Obtaining The Written Permission.</p>
</footer>

<!-- Add the following modal and overlay elements at the end of your HTML in cart.php -->
<div class="modal-overlay" onclick="closeOrderForm()"></div>
<div class="modal" id="orderForm">
    <form action="confirmOrder.php" method="post">
        <!-- Your form fields here -->
        <h3>customer detail form</h3>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required placeholder="enter your name">
        <br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required placeholder="enter your email">
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required placeholder="enter your password">
        <br>
        <label for="phone_number">Phone Number:</label>
        <input type="number" id="phone_number" name="phone_number" required placeholder="enter your 15-20 digigt number">
        <br>
        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required placeholder="enter your address">
        <br>
        <label for="country">Country:</label>
        <input type="text" id="country" name="country" required placeholder="enter your country">
        <br>
        <label for="city">City:</label>
        <input type="text" id="city" name="city" required placeholder="enter your city">
        <br>
        <label for="state">State:</label>
        <input type="text" id="state" name="state" required placeholder="enter your state">
        <br>
        <label for="postal_code">Postal Code:</label>
        <input type="text" id="postal_code" name="postal_code" required placeholder="eg:7500">
        <br>
        <label for="payment_method">Payment Method:</label>
        <select id="payment_method" name="payment_method" required>
        <option value="cash_on_delivery">Cash on Delivery</option>
        <option value="credit_card">Credit Card</option>
        <option value="paypal">PayPal</option>
        </select>
        <input type="submit" value="Submit">
    </form>
</div>

<script>
    function updateQuantity(itemName) {
        var newQuantity = document.getElementById('quantity' + itemName).value;

        // Use AJAX to send data to the server (cart.php) to update the quantity in the session
        fetch('cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'updateQuantity[item]=' + itemName + '&updateQuantity[quantity]=' + newQuantity,
        })
        .then(response => response.json())
        .then(data => {
            console.log('Success:', data);
            // Reload the page to update the cart
            location.reload();
        })
        .catch((error) => {
            console.error('Error:', error);
        });
    }

    function openOrderForm() {
        // Display the modal and overlay
        document.getElementById('orderForm').style.display = 'block';
        document.querySelector('.modal-overlay').style.display = 'block';
        // Add a class to the body to prevent scrolling
        document.body.classList.add('modal-open');
    }

    function closeOrderForm() {
        // Hide the modal and overlay
        document.getElementById('orderForm').style.display = 'none';
        document.querySelector('.modal-overlay').style.display = 'none';
        // Remove the class to allow scrolling
        document.body.classList.remove('modal-open');
    }
</script>
</body>
</html>
