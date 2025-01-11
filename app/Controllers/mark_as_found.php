<?php
require_once '../../database/db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $LFID = $_POST['LFID'] ?? null;

    if ($LFID) {
        try {
            $sql = "UPDATE lost_found SET LFStatus = 'Found' WHERE LFID = :LFID";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':LFID' => $LFID]);

            if ($stmt->rowCount() > 0) {
                echo json_encode(['success' => true, 'message' => 'Item marked as found.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Item not found or already marked as found.']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid item ID.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
