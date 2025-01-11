<?php
require_once '../../database/db.php';

header('Content-Type: application/json');

try {
    $query = isset($_GET['query']) ? $_GET['query'] : '';
    if ($query === '') {
        echo json_encode(['message' => 'No search query provided.']);
        exit;
    }

    $sql = "
        SELECT 
            a.AdminID, 
            u.FirstName, 
            u.LastName, 
            u.Email, 
            u.PhoneNumber
        FROM admin a
        INNER JOIN user u ON a.UserID = u.UserID
        WHERE u.FirstName LIKE :query OR u.LastName LIKE :query
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':query', "%$query%");
    $stmt->execute();
    
    $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Check if employees are fetched
    if ($employees) {
        // Return the employees as JSON
        echo json_encode($employees);
    } else {
        echo json_encode(['message' => 'No Employees found.']);
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
