<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;500;600;800;900;1000&display=swap" rel="stylesheet" />

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.all.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.min.css" rel="stylesheet">

<link rel="stylesheet" href="css/AllCss.css?ii=sadzz" />
<link rel="stylesheet" href="css/all.min.css" />
<link rel="stylesheet" href="lecture.css" />

</head>

    
<body>

<div class="main-flex page">
<?php include('cpanel/sidebar.php');?>
<?php if(isset($_GET['code']) && $_GET['code'] != ""){
    $code = $_GET['code'];
    // Check if the subject exists
    $subjectExists = false;
    $stmtSubject = $MM->prepare('SELECT * FROM subjects WHERE code = ?');
    $stmtSubject->bind_param('s', $code);
    $stmtSubject->execute();
    $resultSubject = $stmtSubject->get_result();
    if ($resultSubject->num_rows > 0) {
        $subjectExists = true;
        $r = $resultSubject->fetch_assoc();
        $subj = $r['name'];
    }

    if ($subjectExists) {
        // fetching lectures from database
        $stmt = $MM->prepare('SELECT * FROM content WHERE subcode = ?');
        $stmt->bind_param('s', $code);
        $stmt->execute();
        $result = $stmt->get_result();
        
        // fetching questions from database
        $stmt2 = $MM->prepare('SELECT DISTINCT q.name, q.subj 
        FROM quiz q
        LEFT JOIN quizh qh ON q.name = qh.qname AND q.subj = qh.qsubj
        WHERE q.subj = ? AND qh.qname IS NULL AND qh.qsubj IS NULL'); // AGAIN SQL IS OP !!.
        $stmt2->bind_param('s', $subj);
        $stmt2->execute();
        $result2 = $stmt2->get_result();
?>
        <div class="quest-long-idk">
            <img src="content-and-imgs/template.png" class="HUM" alt="" />
            <div class="where">
                <span class="text-where">
                    > Lecture & Questions > 
                    <?php
                    echo $subj;
                    ?>
                </span>
            </div>
    </div>
    <div class="container-ALL">
<div class="lecture-section">
  <div class="section-header" onclick="toggleSection(this)">
    <i class="fa-solid fa-chevron-down"></i>
    <h2 class="section-title"
    >محاضرات
    <i class="fa-solid fa-book-open"></i>
  </h2>
  </div>
  <div class="section-content">
    <div class="content-list">
      <?php $num = 0;
      if($result->num_rows > 0) {
          while($e = $result->fetch_assoc()){
              $num++;
      ?>
      <div class="content-item">
                <div class="item-action" onclick="window.location = '/cpanel/<?=$e['pdfurl']?>';">
          <i class="fa-solid fa-download"></i>
        </div>
        <div class="item-details">
          <?php 
          if($e['note'] != "لا يوجد"){
          ?>
          <div class="item-note">
            <p><?=$e['note'];?></p>
          </div>
          <?php 
          }
          ?>
        </div>

                <div class="item-number"><?=$num?></div>

      </div>
      <?php 
          }
      } else {
          echo "<div class='content-item'>لا يوجد محاضرات</div>";
      }
      ?>
    </div>
  </div>
</div>

<!-- Replace the existing questions container with this -->
<div class="questions-section">
  <div class="section-header" onclick="toggleSection(this)">
    <i class="fa-solid fa-chevron-down"></i>
    <h2 class="section-title">
      اسئله
      <i class="fa-solid fa-question"></i>
    </h2>
  </div>
  <div class="section-content">
    <div class="content-list">
      <?php
      if ($result2->num_rows > 0) {
          while ($ress = $result2->fetch_assoc()) {
              $name = $ress['name'];
              $v = mysqli_query($MM, "SELECT * FROM quiz WHERE `subj` = '$subj' AND `name`= '$name'");
              $num = 0;
              while ($e2 = $v->fetch_assoc()) {
                  $num++;
              }
      ?>
      <div class="content-item">
              <div class="item-action" onclick="window.location = 'quiz-user?name=<?= $name ?>&subj=<?= $subj ?>&code=<?= $code ?>';">
          <i class="fa-solid fa-arrow-up-right-from-square"></i>
        </div>
        <div class="item-details">
          <div class="item-title"><?= $name ?></div>
          <div class="item-note">عدد الأسئلة : <?= $num ?></div>
        </div>
                <div class="item-number"><i class="fa-solid fa-question"></i></div>

  
      </div>
      <?php
          }
      }else{
          echo "<div class='content-item'>لا يوجد أسئلة</div>";
      }
      ?>
    </div>
  </div>
</div>
<section class="content-section">
  <div class="section-header" onclick="toggleSection(this)">
    <i class="fa-solid fa-chevron-down collapse-icon"></i>
    <h2 class="section-title">
      الصور 
      <i class="fa-solid fa-images"></i>
    </h2>
  </div>
  <div class="section-content">
    <div class="media-grid">
      <?php
      // Fetch images for this subject
      $stmt_images = $MM->prepare('SELECT * FROM media WHERE type = "image" AND subcode = ? ORDER BY upload_date DESC');
      $stmt_images->bind_param('s', $code);
      $stmt_images->execute();
      $images_result = $stmt_images->get_result();
      
      if($images_result->num_rows > 0) {
        while($image = $images_result->fetch_assoc()){
      ?>
      <div class="media-item" onclick="showImage('cpanel/uploads/media/<?=$image['filename']?>', '<?=htmlspecialchars($image['title'])?>')">
        <div class="media-thumbnail">
          <img src="cpanel/uploads/media/<?=$image['filename']?>" alt="<?=htmlspecialchars($image['title'])?>" />
        </div>
        <div class="media-details">
          <h3 class="media-title"><?=htmlspecialchars($image['title'])?></h3>
          <?php if(!empty($image['description'])): ?>
          <p class="media-description"><?=htmlspecialchars($image['description'])?></p>
          <?php endif; ?>
        </div>
      </div>
      <?php 
        }
      } else {
        echo "<div class='no-media-message'>لا توجد صور متاحة لهذا المقرر</div>";
      }
      $stmt_images->close();
      ?>
    </div>
  </div>
</section>
        
<!-- Videos Section - Modified to fetch from database -->
<section class="content-section" style="margin-bottom: 2rem;">
  <div class="section-header" onclick="toggleSection(this)">
    <i class="fa-solid fa-chevron-down collapse-icon"></i>
    <h2 class="section-title">
      الفيديوهات 
      <i class="fa-solid fa-video"></i>
    </h2>
  </div>
  <div class="section-content">
    <div class="media-grid">
      <?php
      // Fetch videos for this subject
      $stmt_videos = $MM->prepare('SELECT * FROM media WHERE type = "video" AND subcode = ? ORDER BY upload_date DESC');
      $stmt_videos->bind_param('s', $code);
      $stmt_videos->execute();
      $videos_result = $stmt_videos->get_result();
      
      if($videos_result->num_rows > 0) {
        while($video = $videos_result->fetch_assoc()){
          // Use thumbnail if available, otherwise use a placeholder
          $thumbnail = !empty($video['thumbnail']) ? 'cpanel/uploads/media/'.$video['thumbnail'] : '/api/placeholder/400/320';
      ?>
      <div class="media-item" onclick="playVideo('cpanel/uploads/media/<?=$video['filename']?>')">
        <div class="media-thumbnail">
          <img src="<?=$thumbnail?>" alt="غلاف الفيديو" />
          <div class="play-icon">
            <i class="fa-solid fa-play"></i>
          </div>
        </div>
        <div class="media-details">
          <h3 class="media-title"><?=htmlspecialchars($video['title'])?></h3>
          <?php if(!empty($video['description'])): ?>
          <p class="media-description"><?=htmlspecialchars($video['description'])?></p>
          <?php endif; ?>
        </div>
      </div>
      <?php 
        }
      } else {
        echo "<div class='no-media-message'>لا توجد فيديوهات متاحة لهذا المقرر</div>";
      }
      $stmt_videos->close();
      ?>
    </div>
  </div>
</section>
    </div>
    
    <script>
      function playVideo(videoUrl) {
        Swal.fire({
          html: '<video width="100%" controls autoplay><source src="' + videoUrl + '" type="video/mp4">Your browser does not support the video tag.</video>',
          width: "80%",
          showConfirmButton: false,
          showCloseButton: true,
          customClass: {
            container: "video-modal-container",
          },
        });
      }
      
      function showImage(imageUrl, title) {
        Swal.fire({
          title: title,
          imageUrl: imageUrl,
          imageAlt: title,
          width: "auto",
          showCloseButton: true,
          showConfirmButton: false
        });
      }
       document.getElementById('sidebarToggle').addEventListener('click', function() {
      document.getElementById('sidebar').classList.toggle('active');
    });
    
    function toggleSection(element) {
      element.classList.toggle('active');
      const content = element.nextElementSibling;
      
      if (content.classList.contains('show')) {
        content.classList.remove('show');
      } else {
        content.classList.add('show');
      }
    }
    
    // Auto-expand first section on page load
    document.addEventListener('DOMContentLoaded', function() {
      const firstSection = document.querySelector('.section-header');
      if (firstSection) {
        firstSection.classList.add('active');
        firstSection.nextElementSibling.classList.add('show');
      }
    });

        function playVideo(videoUrl) {
          Swal.fire({
            html:
              '<video width="100%" controls autoplay><source src="' +
              videoUrl +
              '" type="video/mp4">Your browser does not support the video tag.</video>',
            width: "80%",
            showConfirmButton: false,
            showCloseButton: true,
            customClass: {
              container: "video-modal-container",
            },
          });
        }
    </script>
    <script>
      function toggleSection(element) {
  const content = element.nextElementSibling;
  const icon = element.querySelector('i');
  
  if (content.classList.contains('show')) {
    content.classList.remove('show');
    icon.style.transform = 'rotate(0deg)';
  } else {
    content.classList.add('show');
    icon.style.transform = 'rotate(180deg)';
  }
}

// document.addEventListener('DOMContentLoaded', function() {
//   const sections = document.querySelectorAll('.section-header');
//   sections.forEach(section => {
//     toggleSection(section);
//   });
// });
    </script>
</div>
<?php
} else {
?>
    <script>
        Swal.fire({ 
            title: 'جاري التحويل للصفحة الرئيسية',
            text: 'المقرر غير موجود',
            icon: 'error',
            showCancelButton: false,
            showConfirmButton: false,
            timer: 2000,
        }).then(function(){
            window.location = "index";
        });
    </script>
<?php
}
}?>

<!-- Adding the JS file here to ensure it's loaded in all cases -->
<?php include("cpanel/script.php"); ?>

<!-- Additional CSS for collapsible sections -->
<style>

</style>

</body>
</html>

