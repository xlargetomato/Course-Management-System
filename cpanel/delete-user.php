<?php
include("sql.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["username"])) {
    $username = $_POST["username"];
    
    // First, check the user's level
    $checkLevelQuery = "SELECT level FROM usr WHERE username = ?";
    $stmt = $MM->prepare($checkLevelQuery);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        $userLevel = $row['level'];
        $num = $_SESSION['level'] == 3 ? 2 : 3;
        if ($userLevel > $num) {
            echo "لا يمكن حذف هذا المستخدم لأن مستواه أعلى من 2.";
        } else {
            $deleteQuery = "DELETE FROM usr WHERE username = ?";
            $stmt = $MM->prepare($deleteQuery);
            $stmt->bind_param("s", $username);
            
            if ($stmt->execute()) {
                date_default_timezone_set("Africa/Cairo");
                $user = $_SESSION['name'];
                $level = $_SESSION['level'];
                $time = date("Y/m/d H:i:s");
                $action = "حذف المستخدم $username";
                
                mysqli_query($MM, "INSERT INTO `log` (`user`, `action`, `time`, `level`) VALUES ('$user', '$action', '$time', '$level')");
                echo "تم الحذف بنجاح.";
            } else {
                echo "فشل في عملية الحذف: " . $stmt->error;
            }
        }
    } else {
        echo "المستخدم غير موجود.";
    }
    
    $stmt->close();
    $MM->close();
} else {
    echo "Invalid request.";
}
?>