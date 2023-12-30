<?php
require_once './db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nameToDelete = $_POST['nameToDelete'] ?? '';

    // Perform the delete operation (replace 'users' with your actual table name)
    $deleteQuery = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param('s', $nameToDelete);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Unable to delete user']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
?>
