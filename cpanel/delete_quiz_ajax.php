<?php
// delete_quiz_ajax.php
include("sql.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $quizName = $_POST["name"];

    // Check if the quiz name is provided
    if (empty($quizName)) {
        echo "اسم الاختبار مطلوب.";
        exit();
    }

    // Sanitize the input to prevent SQL injection
    $quizName = $MM->real_escape_string($quizName);

    // Perform the deletion query
    $deleteQuery = "DELETE FROM quiz WHERE name = '$quizName'";

    if ($MM->query($deleteQuery) === TRUE) {
        date_default_timezone_set("Africa/Cairo");
        $user = $_SESSION['name'];
        $level = $_SESSION['level'];
        $time = date("Y/m/d H:i:s");
        $action = "تم حذف الاختبار المسمى $quizName";
        mysqli_query($MM,"INSERT INTO `log` (`user`, `action`, `time`, `level`) VALUES ('$user', '$action', '$time', '$level')");
        echo "تم حذف الاختبار بنجاح بإسم: $quizName";
    } else {
        echo "خطأ في حذف الاختبار: " . $MM->error;
    }

    $MM->close();
}
?>
