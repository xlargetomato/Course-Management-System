<?php
include("sql.php");

$query = "SELECT * FROM final_projects";
$result = $MM->query($query);

if ($result) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="card user-card">';
            echo '<h4 class="text-right card-title">' . htmlspecialchars($row['subj']) . '</h4>';
            echo '<p class="text-right card-text"><strong>وصف المشروع :</strong> ' . nl2br(stripcslashes($row['content'])) . '</p>';
            echo '<div class="btn2"><button type="button" class="btn1 btn btn-danger" onclick="deleteAssignment(' . "'" . $row['id'] . "'" . ')">حذف</button></div>';
            echo '</div>';
        }
    } else {
        echo '<p class="text-muted text-right">لا توجد مشاريع نهائية لعرضها حاليًا.</p>';
    }
} else {
    echo '<p class="text-danger text-right">حدث خطأ أثناء استعلام قاعدة البيانات.</p>';
}
?>
