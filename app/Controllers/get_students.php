<?php
require_once '../../database/db.php';

header('Content-Type: application/json');

try {
    $query = isset($_GET['query']) ? $_GET['query'] : '';

    $sql = "
        SELECT 
            s.StudentID, 
            u.FirstName, 
            u.LastName, 
            u.Email, 
            u.PhoneNumber, 
            s.School, 
            s.Room, 
            s.Wilaya
        FROM student s
        INNER JOIN user u ON s.UserID = u.UserID
        WHERE u.FirstName LIKE :query OR u.LastName LIKE :query
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':query', "%$query%");
    $stmt->execute();
    
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Check if students are fetched
    if ($students) {
        // Return the students as JSON
        echo json_encode($students);
    } else {
        echo json_encode(['message' => 'No students found.']);
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
