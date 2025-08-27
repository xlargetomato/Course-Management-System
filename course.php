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
    <link rel="stylesheet" href="css/AllCss.css" />
    <link rel="stylesheet" href="css/all.min.css" />
  </head>
  <style>
    .cCont{
      background-color: var(--hover1);
      display: flex;
      justify-content: space-between;
    }
      .cCont > div {
        margin: 10px;
        text-align: center;
      }
  </style>
  <body>
    <div class="main-flex page">
<?php include("cpanel/sidebar.php"); ?>
          <div class="quest-long-idk">
            <img src="content-and-imgs/template.png" class="HUM" alt="" />
            <div class="where"><span class="text-where">> Courses</span></div>
          </div>
        </div>
        <h1 class="titleB">المقررات</h1>
          <?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

          $res = mysqli_query($MM,"SELECT * FROM subjects");
          if($res->num_rows > 0){
            ?><div class="main-content"><?php
            foreach($res as $e){
              $subj = $e['name'];
              $code = $e['code'];

              // fetching lectures
              $res2 = mysqli_query($MM,"SELECT * FROM `content` WHERE `subcode`='$code'");
              $lectnum = $res2->num_rows;

              // fetching quizez
              $res3 = $MM->prepare('SELECT DISTINCT q.name, q.subj 
                     FROM quiz q
                     LEFT JOIN quizh qh ON q.name = qh.qname AND q.subj = qh.qsubj
                     WHERE q.subj = ? AND qh.qname IS NULL AND qh.qsubj IS NULL'); // SQL is op
              $res3->bind_param('s', $subj);
              $res3->execute();
              $result2 = $res3->get_result();
              $quiznum = $result2->num_rows;

              // this is a useless function that i made to check if the quiz is hidden or not , thank god i found a different approach using SQL only .

              // // fetching hidden quizez to hide it from the counter...
              // $res4 = mysqli_query($MM, "SELECT * FROM quizh");
              // if ($res4) {
              //     // Fetch all rows into an associative array
              //     $hiddenQuizzes = [];
              //     while ($row = $res4->fetch_assoc()) {
              //         $hiddenQuizzes[] = $row; // Store each row in the array
              //     }
              // }

              // foreach($result2 as $var){
              //   foreach($hiddenQuizzes as $hidden){
              //   if($var['name'] == $hidden['qname'] and $subj == $hidden['qsubj']){
              //     $quiznum = $quiznum - 1;
              //   }
              // }
              // }
              
          ?>
          <div class="lectureContainer">
            <div class="textB">
              <h1 style="font-weight: 600;"><?=$subj?></h1><br>
              <div class="cCont">
                <div>
                المحاضرات : <?=$lectnum?>
                </div>
                <div>
                  الاختبارات : <?=$quiznum?>
                </div>
              </div>
            </div>
            <div class="buttons-to-go">
              <button style="background-color: var(--main1);"onclick="window.location = 'lectureOrquestions?code=<?=$e['code']?>';"><i style="color: var(--hover1);"class="fa-solid fa-arrow-up-right-from-square"></i></button>
            </div>
          </div>
          <?php } 
          }else{
          ?>
          <div class="assign-container">
          <div class="textB" style="display: flex; justify-content: center; align-items: center;">
              <h1 style="text-align: center;font-size: 1.5rem;">لا يوجد مقررات حاليا</h1>
            </div>
          </div>
          <?php
          }
          ?>
        </div>
      </div>
    </div>
    <?php include("cpanel/script.php"); ?>
    </body>
</html>
