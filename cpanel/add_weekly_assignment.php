<?php
include("sql.php");
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize inputs
    $subject = isset($_POST['subject']) ? $MM->real_escape_string($_POST['subject']) : '';
    $week = isset($_POST['week']) ? $MM->real_escape_string($_POST['week']) : '';
    $content = isset($_POST['content']) ? $MM->real_escape_string($_POST['content']) : '';
    $type = isset($_POST['type']) ? $MM->real_escape_string($_POST['type']) : 0;

    // Check for null or empty values
    if (empty($subject) || empty($week) || empty($content)) {
        echo "Missing information.";
    } else {
        // Check if an assignment for the subject already exists
        $checkQuery = $MM->prepare("SELECT * FROM weekly WHERE `subj` = ? AND `type` = ? AND `week` = ?");
        $checkQuery->bind_param("sis", $subject, $type, $week);
        $checkQuery->execute();
        $result = $checkQuery->get_result();

        if ($result->num_rows > 0) {
            // Assignment for the course already exists
            echo "Assignment for this course already exists.";
        } else {
            // Use prepared statement to prevent SQL injection
            $insertQuery = $MM->prepare("INSERT INTO weekly (`subj`, `week`, `content`, `type`) VALUES (?, ?, ?, ?)");
            $insertQuery->bind_param("sssi", $subject, $week, $content, $type);

            if ($insertQuery->execute()) {
                date_default_timezone_set("Africa/Cairo");
                $user = $_SESSION['name'];
                $level = $_SESSION['level'];
                $type = $type == 0 ? 'نظري' : 'عملي';
                $time = date("Y/m/d H:i:s");
                $action = "أعد التاسك للمقرر $subject | $type الخاص بالأسبوع $week";
                mysqli_query($MM,"INSERT INTO `log` (`user`, `action`, `time`, `level`) VALUES ('$user', '$action', '$time', '$level')");
                echo "success";
            } else {
                echo "Error: " . $insertQuery->error;
            }

            $insertQuery->close();
        }

        $checkQuery->close();
    }
}
?>
