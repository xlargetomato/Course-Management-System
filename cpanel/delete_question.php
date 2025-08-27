<?php
session_start();
include("sql.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming you have a function to sanitize user inputs
    function sanitizeInput($data) {
        // Implement your sanitization logic here
        return htmlspecialchars(strip_tags(trim($data)));
    }

    $id = sanitizeInput($_POST['id']);
    $res = mysqli_query($MM,"SELECT * FROM `quiz` WHERE `id` = '$id'");
    $res = $res->fetch_assoc();
    $quizName = $res['name'];
    $ques = $res['ques'];
    // Check for null inputs
    if (empty($id)) {
        echo json_encode(array("success" => false, "error" => "Question ID is required"));
        exit();
    }

    $stmt = $MM->prepare("DELETE FROM quiz WHERE id = ?");
    $stmt->bind_param("s", $id);
    $result = $stmt->execute();
    $stmt->close();

    if ($result) {
        date_default_timezone_set("Africa/Cairo");
        $user = $_SESSION['name'];
        $subj = $_SESSION['subj'];
        $level = $_SESSION['level'];
        $time = date("Y/m/d H:i:s");
        $action = "حذف سؤال من الاختبار المسمى $quizName في المادة $subj، وكان السؤال: $ques";
        mysqli_query($MM,"INSERT INTO `log` (`user`, `action`, `time`, `level`) VALUES ('$user', '$action', '$time', '$level')");
        echo json_encode(array("success" => true));
    } else {
        echo json_encode(array("success" => false, "error" => "Database error"));
    }
}
?>
