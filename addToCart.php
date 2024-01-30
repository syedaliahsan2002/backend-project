<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    // Store cart items in the session
    $_SESSION['cartItems'] = $data;

    // Send a response (you can customize it based on your needs)
    echo json_encode(['success' => true]);
} else {
    // Invalid request method
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
