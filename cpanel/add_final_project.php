<?php
include("sql.php");
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize inputs
    $subject = isset($_POST['subject']) ? $MM->real_escape_string($_POST['subject']) : '';
    $content = isset($_POST['content']) ? $MM->real_escape_string($_POST['content']) : '';

    // Check for null or empty values
    if (empty($subject) || empty($content)) {
        echo "Missing information.";
    } else {
        // Check if an assignment for the subject already exists
        $checkQuery = $MM->prepare("SELECT * FROM final_projects WHERE `subj` = ?");
        $checkQuery->bind_param("s", $subject);
        $checkQuery->execute();
        $result = $checkQuery->get_result();

        if ($result->num_rows > 0) {
            // Assignment for the course already exists
            echo "Assignment for this course already exists.";
        } else {
            // Use prepared statement to prevent SQL injection
            $insertQuery = $MM->prepare("INSERT INTO final_projects (`subj`, `content`) VALUES (?, ?)");
            $insertQuery->bind_param("ss", $subject, $content);

            if ($insertQuery->execute()) {
                date_default_timezone_set("Africa/Cairo");
                $user = $_SESSION['name'];
                $level = $_SESSION['level'];
                $time = date("Y/m/d H:i:s");
                $action = "أعد المشروع النهائي للمقرر $subject";
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
