<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;500;600;800;900;1000&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="css/AllCss.css?1=43" />
    <link rel="stylesheet" href="css/all.min.css" />
    <style>
      .title-img-xdxd {
        display: flex;
        margin-bottom: 5px;
        justify-content: space-between;
        gap: 100;
      }
    </style>
  </head>
  <body>
    <div class="main-flex page">
      <?php include("cpanel/sidebar.php"); ?>
          <div class="quest-long-idk">
            <img src="content-and-imgs/template.png" class="HUM" alt="" />
            <div class="where"><span class="text-where">> Final Projects</span></div>
          </div>
        </div>
        <h1 class="titleB">المشاريع النهائية</h1>
        <?php 
        
        $res = mysqli_query($MM,"SELECT * FROM final_projects");
        if($res->num_rows > 0){
      foreach ($res as $row) {
        ?>
<div class="assign-container">
    <div class="text-assign">
        <div class="title-img-xdxd">
            <i class="fa-solid fa-chevron-down"></i>
            <h2 class="title-assign">
              <?=$row['subj']?> 
            </h2>
        </div>
        <p class="notes"><?=nl2br(stripcslashes($row['content']))?></p>
    </div>
</div>
            <?php } 
        }else{
          ?>
          <div class="assign-container">
          <div class="text-assign">
                <div style="text-align:center;"class="">لا يوجد مشاريع نهائية حاليا</div>
          </div>
      </div>
      <?php
        }
            ?>
      </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
      $(document).ready(function(){
    $(".notes").slideUp(0);
  $(".assign-container").click(function(){
      $(this).find("p").slideToggle();
  });
});
    </script>
<?php include("cpanel/script.php"); ?>
</body>
</html>
