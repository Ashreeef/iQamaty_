<?php

require_once '../../database/db.php';

header("Content-Type: application/json");

try {
    // Days of the week starting from Saturday
    $weekDays = ['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

    // Prepare and execute the query
    $stmt = $pdo->prepare("
SELECT 
    m.dayOfWeek,
    m.MType,
    mainDish.DName AS mainDishName,
    secondaryDish.DName AS secondaryDishName,
    dessertDish.DName AS dessertDishName
FROM menu m
LEFT JOIN dishes mainDish ON m.mainID = mainDish.DishID
LEFT JOIN dishes secondaryDish ON m.secondaryID = secondaryDish.DishID
LEFT JOIN dishes dessertDish ON m.dessertID = dessertDish.DishID
WHERE m.dayOfWeek IN ('" . implode("', '", $weekDays) . "')
ORDER BY FIELD(m.dayOfWeek, 'Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday');
    ");
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Format the data into a more structured format
    $menuData = [];
    foreach ($results as $row) {
        $dayOfWeek = $row['dayOfWeek'];
        $menuData[$dayOfWeek][] = [
            'name' => $row['MType'],
            'content' => [
                'main' => $row['mainDishName'],
                'secondary' => $row['secondaryDishName'],
                'dessert' => $row['dessertDishName']
            ]
        ];
    }

    echo json_encode($menuData);
} catch (PDOException $e) {
    http_response_code(500);
    error_log($e->getMessage());
    echo json_encode([
        "error" => "Failed to fetch menu data.",
        "details" => $e->getMessage(),
    ]);
    exit;
} catch (Exception $e) {
    http_response_code(500);
    error_log($e->getMessage());
    echo json_encode([
        "error" => "An unexpected error occurred.",
        "details" => $e->getMessage(),
    ]);
    exit;
}
