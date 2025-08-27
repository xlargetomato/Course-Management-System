<?php
include("sql.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $assignmentId = $_POST["assignmentId"];
    $res = mysqli_query($MM,"SELECT * FROM `weekly` WHERE `id` = '$assignmentId'");
    $res = $res->fetch_assoc();
    $subj = $res['subj'];
    
    // Perform the delete operation, replace 'your_table_name' with your actual table name
    $sql = "DELETE FROM weekly WHERE `id` = ?";
    $stmt = $MM->prepare($sql);
    $stmt->bind_param('i', $assignmentId);


    if ($stmt->execute()) {
        date_default_timezone_set("Africa/Cairo");
        $user = $_SESSION['name'];
        $level = $_SESSION['level'];
        $time = date("Y/m/d H:i:s");
        $action = "تم حذف التكليف للمقرر $subj";
        mysqli_query($MM,"INSERT INTO `log` (`user`, `action`, `time`, `level`) VALUES ('$user', '$action', '$time', '$level')");

        echo "success";
    } else {
        echo "error";
    }
} else {
    echo "error";
}

