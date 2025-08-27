<?php
include("sql.php"); // Make sure to replace with your actual database connection file
session_start();

if ($_SESSION["level"] >= "3") {
    // Check if the request method is POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the data from the AJAX request
        $editUsername = isset($_POST["editUsername"]) ? $_POST["editUsername"] : null;
        $curUsername = isset($_POST["curUsername"]) ? $_POST["curUsername"] : null;
        $editName = isset($_POST["editName"]) ? $_POST["editName"] : null;
        $editPassword = isset($_POST["editPassword"]) ? $_POST["editPassword"] : null;
        $editLevel = isset($_POST["editLevel"]) ? $_POST["editLevel"] : null;

        if($curUsername == $_SESSION['username']){
            date_default_timezone_set("Africa/Cairo");
            $user = $_SESSION['name'];
            $level = $_SESSION['level'];
            $time = date("Y/m/d H:i:s");
            $action = "حاول التلاعب بنفسه ؟؟؟";
            mysqli_query($MM,"INSERT INTO `log` (`user`, `action`, `time`, `level`) VALUES ('$user', '$action', '$time', '$level')");
            echo "Why would you do that ?";
            exit;
        }

        if($editLevel >= 3 && $_SESSION['level'] != 4){
            date_default_timezone_set("Africa/Cairo");
            $user = $_SESSION['name'];
            $level = $_SESSION['level'];
            $time = date("Y/m/d H:i:s");
            $action = "حاول التلاعب بالمستخدم $curUsername";
            mysqli_query($MM,"INSERT INTO `log` (`user`, `action`, `time`, `level`) VALUES ('$user', '$action', '$time', '$level')");
            echo "Blud is not cooking";
            exit;
        }

        // Check if any of the inputs is null
        if ($editUsername === null || $editName === null || $editPassword === null || $editLevel === null) {
            echo "يرجى توفير جميع البيانات المطلوبة.";
            exit();
        }

        // Check the current details before updating
        $currentDetailsQuery = "SELECT username, name, password, level FROM usr WHERE username = ?";
        $currentDetailsStmt = $MM->prepare($currentDetailsQuery);
        $currentDetailsStmt->bind_param("s", $curUsername);
        $currentDetailsStmt->execute();
        $currentDetailsStmt->bind_result($existingUsername, $existingName, $existingPassword, $existingLevel);
        $currentDetailsStmt->fetch();
        $currentDetailsStmt->close();

        // Validate if current user can edit the target user's level
        if ($existingLevel >= $_SESSION['level']) {
            date_default_timezone_set("Africa/Cairo");
            $user = $_SESSION['name'];
            $time = date("Y/m/d H:i:s");
            $action = "حاول تعديل مستخدم ذو مستوى صلاحية أعلى أو مساوي له، المستخدم: $curUsername";
            mysqli_query($MM, "INSERT INTO `log` (`user`, `action`, `time`, `level`) VALUES ('$user', '$action', '$time', '{$_SESSION['level']}')");
            echo "Insufficient permissions to edit this user.";
            exit();
        }

        // Check if there are any actual changes
        if (
            $editUsername === $existingUsername &&
            $editName === $existingName &&
            $editPassword === $existingPassword &&
            $editLevel === $existingLevel
        ) {
            echo "No changes were made to the user information.";
            exit();
        }

        // Prepare the update query with placeholders
        $updateQuery = "UPDATE usr SET username=?, name=?, password=?, level=? WHERE username=?";
        $stmt = $MM->prepare($updateQuery);

        // Bind parameters
        $stmt->bind_param("sssss", $editUsername, $editName, $editPassword, $editLevel, $curUsername);

        // Execute the update query
        if ($stmt->execute()) {
            date_default_timezone_set("Africa/Cairo");
            $user = $_SESSION['name'];
            $level = $_SESSION['level'];
            $time = date("Y/m/d H:i:s");

            // Determine the changes for logging
            $changeDetails = [];
            if ($editLevel > $existingLevel) {
                $editLevel = ($editLevel == 1) ? 'Mod' : (($editLevel == 2) ? 'Admin' : 'Head Admin');
                $existingLevel = ($existingLevel == 1) ? 'Mod' : (($existingLevel == 2) ? 'Admin' : 'Head Admin');
                $changeDetails[] = "تم الترقية من المستوى $existingLevel إلى $editLevel";
            } elseif ($editLevel < $existingLevel) {
                $editLevel = ($editLevel == 1) ? 'Mod' : (($editLevel == 2) ? 'Admin' : 'Head Admin');
                $existingLevel = ($existingLevel == 1) ? 'Mod' : (($existingLevel == 2) ? 'Admin' : 'Head Admin');
                $changeDetails[] = "تم التخفيض من المستوى $existingLevel إلى $editLevel";
            }
            if ($editUsername !== $existingUsername) {
                $changeDetails[] = "تم تغيير اسم المستخدم من $existingUsername إلى $editUsername";
            }
            if ($editName !== $existingName) {
                $changeDetails[] = "تم تغيير الاسم من $existingName إلى $editName";
            }
            if ($editPassword !== $existingPassword) {
                $changeDetails[] = "تم تغيير كلمة المرور";
            }
            
            // تسجيل جميع التغييرات المكتشفة
            $action = "تم تعديل المستخدم $existingUsername; " . implode(", ", $changeDetails);
            mysqli_query($MM, "INSERT INTO `log` (`user`, `action`, `time`, `level`) VALUES ('$user', '$action', '$time', '$level')");
            echo "تم تحديث معلومات المستخدم بنجاح";

        } else {
            echo "حدث خطأ أثناء تحديث معلومات المستخدم: " . $stmt->error;
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        // If the request method is not POST, redirect to the main page
        header('Location: index');
    }
    $MM->close();
} else {
    // If the user does not have the required level, redirect to the main page
    header('Location: controlpanel');
}
?>
