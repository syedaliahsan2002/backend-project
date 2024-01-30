<?php
session_start();
include('connection.php'); // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    // Process and store the customer information in the 'customer' table
    $stmt = $conn->prepare("INSERT INTO customer (username, email, password, phone_number, address, country, city, state, postal_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssisssss", $data['username'], $data['email'], $data['password'], $data['phone_number'], $data['address'], $data['country'], $data['city'], $data['state'], $data['postal_code']);

    if ($stmt->execute()) {
        // Clear the cart items after successful order confirmation
        unset($_SESSION['cartItems']);
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error processing the order']);
    }

    $stmt->close();
} else {
    // Invalid request method
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
