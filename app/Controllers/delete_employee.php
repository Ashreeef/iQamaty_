<?php
include('../auth/functions.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['UserID'];
    $role = $_POST['Role'];

    if (empty($userId) || empty($role)) {
        echo json_encode(['success' => false, 'message' => 'Invalid data provided.']);
        exit();
    }

    try {
        $pdo->beginTransaction();

        if ($role === 'staff') {
            // Remove from Staff table
            $stmt = $pdo->prepare("DELETE FROM Staff WHERE UserID = ?");
            $stmt->execute([$userId]);
        } elseif ($role === 'admin') {
            // Remove from Admin table
            $stmt = $pdo->prepare("DELETE FROM Admin WHERE UserID = ?");
            $stmt->execute([$userId]);
        } else {
            throw new Exception("Invalid role provided.");
        }

        // Remove from User table
        $stmt = $pdo->prepare("DELETE FROM User WHERE UserID = ?");
        $stmt->execute([$userId]);

        $pdo->commit();
        echo json_encode(['success' => true, 'message' => 'Employee removed successfully.']);
    } catch (Exception $e) {
        $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => 'Failed to remove employee: ' . $e->getMessage()]);
    }
}
