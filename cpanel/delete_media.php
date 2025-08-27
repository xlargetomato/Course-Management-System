<?php
// This file should be saved as delete_media.php or similar
session_start();
include("sql.php");

// Check if user is logged in and has admin privileges
if (!isset($_SESSION['level']) || $_SESSION['level'] < 2) {
    echo json_encode(['success' => false, 'error' => 'Unauthorized access']);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];
    
    // Get file paths before deleting the record
    $stmt = $MM->prepare("SELECT filename, thumbnail FROM media WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        // Delete the file from the server
        if (file_exists("uploads/media/" . $row['filename'])) {
            unlink("uploads/media/" . $row['filename']);
        }
        
        // Delete thumbnail if exists
        if (!empty($row['thumbnail']) && file_exists("uploads/media/" . $row['thumbnail'])) {
            unlink("uploads/media/" . $row['thumbnail']);
        }
        
        // Delete record from database
        $delete_stmt = $MM->prepare("DELETE FROM media WHERE id = ?");
        $delete_stmt->bind_param("i", $id);
        
        if ($delete_stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $delete_stmt->error]);
        }
        $delete_stmt->close();
    } else {
        echo json_encode(['success' => false, 'error' => 'Media not found']);
    }
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
}
?>