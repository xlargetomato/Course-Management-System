<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;500;600;800;900;1000&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="css/AllCss.css?v=s1dadss4" />
    <link rel="stylesheet" href="css/all.min.css" />
    <title>Control Panel</title>
  </head>
  <body>
    <div class="main-flex page">
      <?php include("cpanel/sidebar.php"); ?>

      <div class="quest-long-idk">
        <img src="content-and-imgs/template.png" class="HUM" alt="Template Image" />
        <div class="where">
          <span class="text-where">&gt; Control Panel</span>
        </div>
      </div>

      <div class="container-control-panel">
        <div class="container-buttons">
          <h1 class="tshadow"><i class="fa-solid fa-gears"></i> وحدة التحكم</h1>
          <?php include('cpanel/login.php'); ?>

          <?php if($_SESSION['level'] != "") { ?>
            <div class="visit-stats">
              <?php if($_SESSION['level'] == 4) {
                // Database queries
                if (!$MM) {
                    die("Connection failed: " . mysqli_connect_error());
                }
                date_default_timezone_set("Africa/Cairo");
                $today_date = date('Y-m-d');
                $sql_daily_visits = "SELECT visit_count FROM daily_visits WHERE visit_date = '$today_date'";
                $result_daily_visits = mysqli_query($MM, $sql_daily_visits);
                $row_daily_visits = mysqli_fetch_assoc($result_daily_visits);
                $daily_visits = $row_daily_visits['visit_count'];

                $sql_total_visits = "SELECT visit_count FROM total_visits";
                $result_total_visits = mysqli_query($MM, $sql_total_visits);
                $row_total_visits = mysqli_fetch_assoc($result_total_visits);
                $total_visits = $row_total_visits['visit_count'];

                mysqli_close($MM);
                echo "<div>زيارات اليوم : " . $daily_visits . "</div>";
                echo "<div>إجمالي الزيارات : " . $total_visits . "</div>";
              } ?>
            </div>

            <div class="buttons-cpanel">
              <?php if($_SESSION['level'] > 1) { ?>
                <div class="buttons-cpanels" data-link="cpanel/view-mat"><i class="fa-solid fa-box-archive"></i><br> إدارة المحاضرات</div>
                <div class="buttons-cpanels" data-link="cpanel/videos-and-photos" style=""><i class="fa-solid fa-photo-film"></i><br>  الفيديوهات والصور</div>
              <?php } if($_SESSION["level"] >= 3) { ?>
                <div class="buttons-cpanels" data-link="cpanel/manage-users"><i class="fa-solid fa-users-gear"></i><br> إدارة المستخدمين</div>
                <?php } ?>

              <?php if($_SESSION["level"] >= 2) { ?>
                <div class="buttons-cpanels" data-link="cpanel/assignment-manage"><i class="fa-solid fa-list-check"></i><br> إدارة التكاليف</div>
              <?php } if($_SESSION["level"] >= 2) { ?>
                <div class="buttons-cpanels" data-link="cpanel/final-projects-manage"><i class="fa-solid fa-list"></i><br> المشاريع النهائية</div>
              <?php } if($_SESSION["level"] >= 3) { ?>
                <div class="buttons-cpanels" data-link="cpanel/sub-manage"><i class="fa-solid fa-book"></i><br> إدارة المقررات</div>
              <?php } ?>

              <div class="buttons-cpanels" data-link="cpanel/quiz"><i class="fa-solid fa-gear"></i><br> إدارة الاختبارات</div>

              <?php if($_SESSION["level"] == 4) { ?>
                <div class="buttons-cpanels" data-link="cpanel/history"><i class="fa-solid fa-clock-rotate-left"></i><br> السجل</div>
              <?php } ?>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>

    <script>
      document.querySelectorAll('.buttons-cpanels').forEach(button => {
        button.addEventListener('click', function() {
          window.location = button.getAttribute('data-link');
        });
      });
    </script>
<?php include("cpanel/script.php"); ?>
</body>
</html>
