<?php

require_once '../../database/db.php';
header('Content-Type: application/json');
try {
    // Fetch dishes grouped by type
    $stmt = $pdo->query("SELECT DishID, DName, DType FROM dishes");
    $dishes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $groupedDishes = [
        "main dish" => [],
        "secondary dish" => [],
        "dessert" => [],
    ];

    foreach ($dishes as $dish) {
        $groupedDishes[$dish['DType']][] = [
            "DishID" => $dish['DishID'],
            "DName" => $dish['DName']
        ];
    }

    echo json_encode([
        "success" => true,
        "data" => $groupedDishes,
    ]);
} catch (PDOException $e) {
    echo json_encode([
        "success" => false,
        "message" => "Database error: " . $e->getMessage(),
    ]);
}
?>

