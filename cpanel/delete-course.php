<?php
// Include your SQL connection file
include("sql.php");
session_start();
// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the course code from the POST data
    $courseCode = $_POST["courseCode"];

    //fetching subject name from table subjects
    $r = $MM->prepare("SELECT * FROM subjects WHERE code = ?"); 
    $r->bind_param("s", $courseCode);
    $r->execute();
    $r = $r->get_result(); 
    $r = $r->fetch_assoc();
    $subj = $r['name'];
    
    $res1 = $MM->prepare("DELETE FROM quiz WHERE subj = ?");
    $res1->bind_param("s", $subj);
    $res1->execute();    

    $res2 = $MM->prepare("DELETE FROM weekly WHERE subj = ?");
    $res2->bind_param("s", $subj);
    $res2->execute();

    // Prepare the delete query with a placeholder
    $deleteQuery = "DELETE FROM subjects WHERE code = ?";
    $stmt = $MM->prepare($deleteQuery);

    // Bind the parameter
    $stmt->bind_param("s", $courseCode);

    // Execute the delete query
    if ($stmt->execute()) {
        // Now, fetch related content records
        $selectQuery = "SELECT * FROM content WHERE subcode = ?";
        $stmtSelect = $MM->prepare($selectQuery);
        $stmtSelect->bind_param("s", $courseCode);
        $stmtSelect->execute();
        $result = $stmtSelect->get_result();

        // Loop through the result and delete associated records and files
        while ($row = $result->fetch_assoc()) {
            $pdfUrlToDelete = urldecode($row['pdfurl']);

            // Delete the record from the database
            $deleteContentQuery = "DELETE FROM content WHERE pdfurl = ?";
            $stmtDeleteContent = $MM->prepare($deleteContentQuery);
            $stmtDeleteContent->bind_param("s", $pdfUrlToDelete);

            if ($stmtDeleteContent->execute()) {
                // Delete the actual file from the server
                unlink($pdfUrlToDelete);
            }
        }

        $stmtSelect->close();

        date_default_timezone_set("Africa/Cairo");
        $user = $_SESSION['name'];
        $level = $_SESSION['level'];
        $time = date("Y/m/d H:i:s");
        $action = "حذف مقرر $subj";
        mysqli_query($MM,"INSERT INTO `log` (`user`, `action`, `time`, `level`) VALUES ('$user', '$action', '$time', '$level')");
        
        echo "تم الحذف بنجاح.";
    } else {
        echo "خطأ أثناء الحذف: " . $MM->error;
    }

    // Close the prepared statement
    $stmt->close();

    // Close the database connection
    $MM->close();
}
?>
