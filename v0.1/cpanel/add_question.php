<?php
session_start();
include("sql.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming you have a function to sanitize user inputs
    function sanitizeInput($data) {
        // Implement your sanitization logic here
        return htmlspecialchars(strip_tags(trim($data)));
    }

    $subj = sanitizeInput($_SESSION['subj']);
    $name = sanitizeInput($_SESSION['name']);
    $type = sanitizeInput($_POST['type']);
    $ques = sanitizeInput($_POST['ques']);
    $opt1 = sanitizeInput($_POST['opt1']);
    $opt2 = sanitizeInput($_POST['opt2']);
    $opt3 = sanitizeInput($_POST['opt3']);
    $opt4 = sanitizeInput($_POST['opt4']);
    $ans = sanitizeInput($_POST['ans']);
    $corr = sanitizeInput($_POST['corr']);
    
    if(empty($corr)){$corr = "null";}

    // Check for null inputs
    switch($type){
    case "choose":
    if (empty($subj) || empty($type) || empty($name) || empty($ques) || empty($opt1) || empty($opt2) || empty($opt3) || empty($opt4) || empty($ans) || empty($corr)) {
        echo json_encode(array("success" => false, "error" => "All fields are required"));
        exit();
    }
    $stmt = $MM->prepare("INSERT INTO quiz (subj, type, name, ques, opt1, opt2, opt3, opt4, ans, corr) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssss", $subj, $type, $name, $ques, $opt1, $opt2, $opt3, $opt4, $ans, $corr);
    $result = $stmt->execute();
    $stmt->close();
    break;
    case "trueOrFalse":
        $null = "null";
        $ans = sanitizeInput($_POST['Tru']);
        if (empty($subj) || empty($type) || empty($name) || empty($ans)) {
            echo json_encode(array("success" => false, "error" => "All fields are required"));
            exit();
        }
    $stmt = $MM->prepare("INSERT INTO quiz (subj, type, name, ques, opt1, opt2, opt3, opt4, ans, corr) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssss", $subj, $type, $name, $ques, $null, $null, $null, $null, $ans, $corr);
    $result = $stmt->execute();
    $stmt->close();
    break;
    }  

    if ($result) {
        echo json_encode(array("success" => true));
    } else {
        echo json_encode(array("success" => false, "error" => "Database error"));
    }
}
?>
