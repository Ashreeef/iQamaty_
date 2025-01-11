<?php
require_once '../../database/db.php'; // Adjust the path as needed

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['TeamID'])) {
        $teamID = intval($_GET['TeamID']);

        $stmt = $pdo->prepare("
            SELECT tm.StudentID, CONCAT(u.firstName, ' ', u.lastName) AS StudentName, tm.TMDate
            FROM team_members tm
            JOIN student s ON tm.StudentID = s.StudentID
            JOIN user u ON s.UserID = u.UserID
            WHERE tm.TeamID = :TeamID
        ");
        $stmt->execute([':TeamID' => $teamID]);
        $members = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            'success' => true,
            'data' => $members,
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid request or missing TeamID.',
        ]);
    }
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage(),
    ]);
}
?>
