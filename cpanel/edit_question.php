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
    $type = sanitizeInput($_POST['editType']);
    $ques = sanitizeInput($_POST['ques']);
    $opt1 = sanitizeInput($_POST['opt1']);
    $opt2 = sanitizeInput($_POST['opt2']);
    $opt3 = sanitizeInput($_POST['opt3']);
    $opt4 = sanitizeInput($_POST['opt4']);
    $ans = sanitizeInput($_POST['ans']);
    $corr = sanitizeInput($_POST['corr']);

    if(empty($corr)){$corr = "null";}
    switch ($type) {
        case "choose":
    // Check for null inputs
        if (empty($id) || empty($type) || empty($ques) || empty($opt1) || empty($opt2) || empty($opt3) || empty($opt4) || empty($ans) || empty($corr)) {
            echo json_encode(array("success" => false, "error" => "All fields are required"));
            exit();
        }
        $stmt = $MM->prepare("UPDATE quiz SET type = ?, ques = ?, opt1 = ?, opt2 = ?, opt3 = ?, opt4 = ?, ans = ?, corr = ? WHERE id = ?");
        $stmt->bind_param("ssssssssi", $type, $ques, $opt1, $opt2, $opt3, $opt4, $ans, $corr, $id);
        $result = $stmt->execute();
        $stmt->close();
    break;

    case "trueOrFalse":
        $ans = sanitizeInput($_POST['editTru']);
        if (empty($id) || empty($type) || empty($ques) || empty($ans)) {
            echo json_encode(array("success" => false, "error" => "All fields are required"));
            exit();
        }
        $null = "null";
        $stmt = $MM->prepare("UPDATE quiz SET type = ?, ques = ?, opt1 = ?, opt2 = ?, opt3 = ?, opt4 = ?, ans = ?, corr = ? WHERE id = ?");
        $stmt->bind_param("ssssssssi", $type, $ques, $null, $null, $null, $null, $ans, $null, $id);
        $result = $stmt->execute();
        $stmt->close();

        $res = mysqli_query($MM,"SELECT * FROM `quiz` WHERE `id` = '$id'");
        $res = $res->fetch_assoc();
        $quizName = $res['name'];
        $ques = $res['ques'];

    break;

    }

    if ($result) {

        date_default_timezone_set("Africa/Cairo");
        $user = $_SESSION['name'];
        $subj = $_SESSION['subj'];
        $level = $_SESSION['level'];
        $time = date("Y/m/d H:i:s");
        $action = "حدث السؤال $ques من الاختبار المسمى $quizName في المقرر $subj";
        mysqli_query($MM,"INSERT INTO `log` (`user`, `action`, `time`, `level`) VALUES ('$user', '$action', '$time', '$level')");

        echo json_encode(array("success" => true));
    } else {
        echo json_encode(array("success" => false, "error" => "Database error"));
    }
}
?>
