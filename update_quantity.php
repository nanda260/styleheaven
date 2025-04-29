<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

$user_id = $_SESSION['user_id'];
$cart_id = $_POST['id'];
$action = $_POST['action'];

$sql = "SELECT quantity FROM cart WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $cart_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    echo json_encode(['error' => 'Cart item not found']);
    exit();
}

$quantity = (int) $row['quantity'];

if ($action === 'increment') {
    $quantity += 1;

    $update = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ? AND user_id = ?");
    $update->bind_param("iii", $quantity, $cart_id, $user_id);
    $update->execute();

    echo json_encode(['success' => true, 'new_quantity' => $quantity]);
    exit();

} elseif ($action === 'decrement') {
    $quantity -= 1;

    if ($quantity <= 0) {
        $delete = $conn->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
        $delete->bind_param("ii", $cart_id, $user_id);
        $delete->execute();

        echo json_encode(['success' => true, 'deleted' => true]);
        exit();
    } else {
        $update = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ? AND user_id = ?");
        $update->bind_param("iii", $quantity, $cart_id, $user_id);
        $update->execute();

        echo json_encode(['success' => true, 'new_quantity' => $quantity]);
        exit();
    }
}

echo json_encode(['error' => 'Invalid action']);
