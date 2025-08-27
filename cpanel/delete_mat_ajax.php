<?php
session_start();

if ($_SESSION['level'] != 2 && $_SESSION['level'] != 3 && $_SESSION['level'] != 4) {
    echo 'Insufficient permissions.';
    exit;
}

if (isset($_POST['pdfurl'])) {
    $pdfUrlToDelete = urldecode($_POST['pdfurl']);
    $subcode = $_POST['Subcode'];
    $id = $_POST['Id'];

    // تضمين ملف الاتصال بقاعدة البيانات
    include 'sql.php';

    // جلب اسم المقرر من جدول subjects
    $courseNameQuery = "SELECT name FROM subjects WHERE code = ?";
    $stmtCourse = $MM->prepare($courseNameQuery);
    $stmtCourse->bind_param("s", $subcode);
    $stmtCourse->execute();
    $resultCourse = $stmtCourse->get_result();

    if ($resultCourse->num_rows > 0) {
        $row = $resultCourse->fetch_assoc();
        $courseName = $row['name'];
    } else {
        $courseName = "غير معروف";
    }
    $stmtCourse->close();

    // جلب الملاحظة (note) المرتبطة بالملف
    $noteQuery = "SELECT note FROM content WHERE pdfurl = ?";
    $stmtNote = $MM->prepare($noteQuery);
    $stmtNote->bind_param("s", $pdfUrlToDelete);
    $stmtNote->execute();
    $resultNote = $stmtNote->get_result();
    
    if ($resultNote->num_rows > 0) {
        $row = $resultNote->fetch_assoc();
        $note = $row['note'];
    } else {
        $note = "غير معروف";
    }
    $stmtNote->close();

    // تنفيذ عملية الحذف من جدول المحتوى
    $deleteQuery = "DELETE FROM content WHERE pdfurl = ?";
    $stmt = $MM->prepare($deleteQuery);
    $stmt->bind_param("s", $pdfUrlToDelete);

    if ($stmt->execute()) {
        // حذف الملف الفعلي من الخادم
        unlink($pdfUrlToDelete);
        
        // تسجيل العملية في سجل النظام
        date_default_timezone_set("Africa/Cairo");
        $user = $_SESSION['name'];
        $level = $_SESSION['level'];
        $time = date("Y/m/d H:i:s");
        $action = "حذف المحاضرة '$note' من مقرر '$courseName'";

        $logQuery = "INSERT INTO `log` (`user`, `action`, `time`, `level`) VALUES (?, ?, ?, ?)";
        $stmtLog = $MM->prepare($logQuery);
        $stmtLog->bind_param("sssi", $user, $action, $time, $level);
        $stmtLog->execute();
        $stmtLog->close();

        echo "تم حذف المحاضرة '$note' من مقرر '$courseName' وتسجيل العملية بنجاح.";
    } else {
        echo "حدث خطأ أثناء حذف الملف والسجل: " . $stmt->error;
    }

    $stmt->close();
    $MM->close();
} else {
    echo "لم يتم تحديد ملف لحذفه.";
}
?>
