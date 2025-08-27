<?php
session_start();
include("sql.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Collect input data
    $addUsername = isset($_POST["addUsername"]) ? $_POST["addUsername"] : null;
    $addName = isset($_POST["addName"]) ? $_POST["addName"] : null;
    $addPassword = isset($_POST["addPassword"]) ? $_POST["addPassword"] : null;
    $addLevel = isset($_POST["addLevel"]) ? $_POST["addLevel"] : null;
    if($addLevel > 2){
        if($_SESSION['level'] < 4){
            echo 'nice try man';
            date_default_timezone_set("Africa/Cairo");
            $user = $_SESSION['name'];
            $level = $_SESSION['level'];
            $time = date("Y/m/d H:i:s");
            $action = "حاول التلاعب بالأذونات وإنشاء مستخدم باسم $addUsername";
            mysqli_query($MM,"INSERT INTO `log` (`user`, `action`, `time`, `level`) VALUES ('$user', '$action', '$time', '$level')");
            exit;
        }
    }
    // Check if any of the inputs is null
    if ($addUsername === null || $addName === null || $addPassword === null || $addLevel === null) {
        echo "يرجى توفير جميع البيانات المطلوبة.";
        exit();
    }

    // Prepare the statement
    $insertQuery = $MM->prepare("INSERT INTO usr (username, name, password, level) VALUES (?, ?, ?, ?)");

    // Bind parameters
    $insertQuery->bind_param("sssi", $addUsername, $addName, $addPassword, $addLevel);

    // Execute the statement
    if ($insertQuery->execute()) {
        date_default_timezone_set("Africa/Cairo");
        $user = $_SESSION['name'];
        $level = $_SESSION['level'];
        $time = date("Y/m/d H:i:s");
        $action = "أنشاء مستخدم بإسم $addUsername";
        mysqli_query($MM,"INSERT INTO `log` (`user`, `action`, `time`, `level`) VALUES ('$user', '$action', '$time', '$level')");
        echo "تمت الإضافة بنجاح.";
    } else {
        echo "فشل في عملية الإضافة: " . $MM->error;
    }

    // Close the statement
    $insertQuery->close();
    $MM->close();
} else {
    echo "Invalid request.";
}
?>
