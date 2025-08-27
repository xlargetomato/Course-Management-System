<?php
include("sql.php");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="sub.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="icon" href="/slider/book-_1_.ico">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;500;600;800;900;1000&display=swap" rel="stylesheet">
 
<title>Lecture</title>
    <link rel="icon" href="contents/2131.jpg">
  </head>
  <script>
    let hostname = window.location.hostname;
  </script>
  <script src="sub.js"></script>
  <div class="navbares">
  <ul onclick="window.location = '/index';">
    <li><a>الصفحة الرئيسية</a></li>
</ul>
    <img width="53px" src="LOGO white.png" alt="" />
  </div>
          <h1 class="titleone">المحاضرات</h1>
          <div class="container">
          <?php 
            $stmt = mysqli_prepare($MM, "SELECT * FROM `content` WHERE `subcode`=? ORDER BY lectnum asc");
            mysqli_stmt_bind_param($stmt, "s", $_GET['code']);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $num = 0;
            foreach($result as $x){ $num++;?>
    <div class="mki">
      <h1>المحاضره #<?=$x['lectnum']?></h1>
      <p>ملاحظات: <?=$x['note']?></p>
        <a>
        <button onclick="window.location = '/cpanel/<?=$x['pdfurl']?>' ">اضغط هنا</button>
        </a>      </div>
    <?php } if($num == 0){ ?>
      <div class="mki">
      <h1>لا يوجد حاليا محاضرات لهذا المقرر</h1>
</div>
    </div>
    <?php }  ?>
    </div>
    </body>
</html>