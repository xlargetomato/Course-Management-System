<?php
include("sql.php");

// تعديل الاستعلام لفرز النتائج حسب الأسبوع
$query = "SELECT * FROM weekly ORDER BY week ASC";
$result = $MM->query($query);

if ($result) {
    if ($result->num_rows > 0) {
        // تجميع التكليفات حسب الأسبوع
        $assignmentsByWeek = [];
        while ($row = $result->fetch_assoc()) {
            $week = $row['week'];
            if (!isset($assignmentsByWeek[$week])) {
                $assignmentsByWeek[$week] = [];
            }
            $assignmentsByWeek[$week][] = $row;
        }
        
        // عرض التكليفات مجموعة حسب كل أسبوع
        foreach ($assignmentsByWeek as $week => $assignments) {
            echo '<h3 class="text-right" style="color: var(--main1);font-weight: 500;">الأسبوع: ' . htmlspecialchars($week) . '</h3><br>';
            foreach ($assignments as $assignment) {
                $type = $assignment['type'] == 0 ? 'نظري' : 'عملي';
                echo '<div class="card user-card">';
                echo '<h4 class="text-right card-title">' . htmlspecialchars($assignment['subj']) . ' ' . "($type)" . '</h4>';
                echo '<p class="text-right card-text"><strong>التكليف :</strong> ' . nl2br(stripcslashes($assignment['content'])) . '</p>';
                echo '<div class="btn2"><button type="button" class="btn1 btn btn-danger" onclick="deleteAssignment(' . "'" . $assignment['id'] . "'" . ')">حذف</button></div>';
                echo '</div>';
            }
        }
    } else {
        echo '<p class="text-muted text-right">لا توجد تكليفات لعرضها حاليًا.</p>';
    }
} else {
    echo '<p class="text-danger text-right">حدث خطأ أثناء استعلام قاعدة البيانات.</p>';
}
?>
