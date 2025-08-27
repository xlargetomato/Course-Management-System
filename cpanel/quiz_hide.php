<?php
session_start();
include("sql.php");
$action = $_POST['action'];
$subj = $_POST['subj'];
$name = $_POST['name'];
if(empty($name) OR empty($subj) OR empty($action)){
    echo "null input";
}else{
switch ($action){
    case "hide":
        $insert = $MM->prepare("INSERT INTO quizh (qsubj,qname) VALUES (?, ?)");
        $insert->bind_param("ss",$subj,$name);
        if($insert->execute()){
            date_default_timezone_set("Africa/Cairo");
            $user = $_SESSION['name'];
            $level = $_SESSION['level'];
            $time = date("Y/m/d H:i:s");
            $action = "جعل الاختبار $name من المادة $subj غير مرئي";
            mysqli_query($MM,"INSERT INTO `log` (`user`, `action`, `time`, `level`) VALUES ('$user', '$action', '$time', '$level')");
            echo 1;
        }else{
            echo 0;
        }
        break;
    case "unhide":
        $del = $MM->prepare("DELETE FROM quizh WHERE qsubj=? and qname=?");
        $del->bind_param("ss", $subj, $name);
        if($del->execute()){
            date_default_timezone_set("Africa/Cairo");
            $user = $_SESSION['name'];
            $level = $_SESSION['level'];
            $time = date("Y/m/d H:i:s");
            $action = "جعل الاختبار $name من المادة $subj مرئي";
            mysqli_query($MM,"INSERT INTO `log` (`user`, `action`, `time`, `level`) VALUES ('$user', '$action', '$time', '$level')");
            echo 1;
        }else{
            echo 0;
        }
        break;

}
}
?>
