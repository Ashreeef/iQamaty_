<?php
require_once '../../database/db.php'; // Adjust path

header('Content-Type: application/json');

try {
    $data = json_decode(file_get_contents("php://input"), true);
    $dishID = $data['dishID'] ?? null;

    if ($dishID) {
        $sql = "DELETE FROM dishes WHERE DishID = :dishID";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['dishID' => $dishID]);

        echo json_encode(['success' => true, 'message' => 'Dish deleted successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid Dish ID.']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>