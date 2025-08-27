<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link rel="stylesheet" href="sub.css">
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;500;600;800;900;1000&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="css/AllCss.css?ver=12" />
  <link rel="stylesheet" href="css/all.min.css" />
  <div class="main-flex page">
</head>
<link rel="stylesheet" href="quiz.css?sa=2xxxxxx">
<?php
include("sidebar.php");
include("short.php");
session_start();
if ($_SESSION["level"] != "") {
?>
<body>
  <div class="quest-long-idk">
    <img src="content-and-imgs/template.png" class="HUM" alt="" />
    <div class="where"><span class="text-where">> ControlPanel > Quiz Management</span></div>
  </div>
  <div class="rtl" style="direction: rtl;">
    <center>
      <h2 class="mt-4 mb-4">عرض وتحرير الاختبارات</h2>
    </center>
    <style>
      .cCont {
        background-color: var(--hover1);
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
      }

      .cCont>button {
        margin: 10px;
        text-align: center;
      }
    </style>
    <div class="container">
      <div class="cCont">
        <button class="btn btn-success" onclick="location.href='quiz-step-1.php'">إضافة +</button>
        <button class="btn" onclick="window.location = '/controlpanel';" style="color: var(--main2);background-color: var(--main1);"><i class="fa-solid fa-arrow-left"></i></button>
      </div>
      <div class="card-container-two">
        <?php
        $res = mysqli_query($MM, "SELECT * FROM quizh");
        if ($res) {
          // Fetch all rows into an associative array
          $hiddenQuizzes = [];
          while ($row = $res->fetch_assoc()) {
            $hiddenQuizzes[] = $row; // Store each row in the array
          }

          $subjectsQuery = $MM->query("SELECT DISTINCT subj FROM quiz");

          $quizzesExist = false;

          while ($subjectRow = $subjectsQuery->fetch_assoc()) {
            $subject = $subjectRow['subj'];
        ?>
            <div class="container-small-idk">
              <h3 style=""><?php echo $subject; ?></h3>
              <?php
              $quizzesQuery = $MM->query("SELECT * FROM quiz WHERE subj = '$subject' GROUP BY name");
              if ($quizzesQuery->num_rows > 0) {
                while ($quizRow = $quizzesQuery->fetch_assoc()) {
                  $quizName = $quizRow['name'];
                  $quizId = $quizRow['id'];
                  $quizSub = $quizRow['subj'];

                  // Count the number of questions for each quiz
                  $questionsCountQuery = $MM->query("SELECT * FROM quiz WHERE name = '$quizName' and subj = '$quizSub'");
                  $questionsCount = $questionsCountQuery->num_rows;
              ?>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-xs-9">
                        <h4 class="quiz-name"><?php echo $quizName; ?></h4>
                        <div class="x">
                        <label class="switch">
                          <input type="checkbox" class="check" data-subj="<?= $quizSub ?>" data-name="<?= $quizName ?>" <?php
                            // Check if the current quiz is hidden
                            $hidden = false;
                            foreach ($hiddenQuizzes as $hiddenQuiz) {
                                if ($hiddenQuiz['qname'] == $quizName && $hiddenQuiz['qsubj'] == $quizSub) {
                                $hidden = true;
                                break;
                                }
                            }
                            if (!$hidden) {
                                echo 'checked';
                            }
                            ?>>
                          <span class="slider round" style=""></span>
                        </label>
                        <div style="color: black;"><?php echo (!$hidden) ? 'ظاهر' : 'مخفي'; ?></div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div style="margin:auto;" class="col-xs-12">
                        <p class="label">عدد الأسئلة: <?php echo $questionsCount; ?></p>
                      </div>
                    </div>
                    <div class="row">
                      <div style="margin:auto;" class="col-xs-3">
                        <button class="btn btn-url" data-url="<?php echo 'https://'. $_SERVER['SERVER_NAME'] . '/quiz?id=' . enc("$quizSub-$quizName", "quiz"); ?>"><i class="fa-solid fa-link"></i>
                        <button class="btn btn-warning btn-edit" onclick='window.location= "quiz-manage?name=<?php echo $quizName; ?>&subj=<?php echo $quizSub;?>"'><i class="fa-solid fa-pencil"></i>
                        </button>
                        <button class="btn btn-danger btn-delete" onclick='deleteQuiz("<?php echo $quizName; ?>")'><i class="fa-solid fa-trash"></i>
                        </button>
                      </div>
                    </div>
                  </div>
              <?php

                }
              } else {
                echo "<p class='text-muted text-right'>لا يوجد اختبارات حاليا</p>";
              }
              ?>
            </div>
        <?php
            $quizzesExist = true;
          }

          if (!$quizzesExist) {
            echo "<p class='text-muted text-right'>لا يوجد اختبارات حاليا</p>";
          }
        ?>
      </div>
    </div>
  </div>
  <script>
$('.btn-url').on('click',function(){
  url = $(this).data('url');
  var tempInput = $("<input>");
  // Append the hidden value to the temporary input
  $("body").append(tempInput);
  
  // Set the value of the temporary input to the hidden value
  tempInput.val(url).select();
  
  // Copy the selected text to the clipboard
  document.execCommand("copy");
  
  // Remove the temporary input
  tempInput.remove();

  // Alert the user
  alert("تم نسخ الرابط");
});
$('input[type=checkbox]').on('change', function () {
    var checkbox = $(this);
    var ssubj = checkbox.data("subj");
    var sname = checkbox.data("name");

    if (checkbox.is(":checked")) {
        $.ajax({
            type: 'POST',
            url: 'quiz_hide.php',
            data: { action: 'unhide', name: sname, subj: ssubj },
            success: function (response) {
                response = response.replace("</p>", "");
                if (response == 1) {
                    Swal.fire({
                        icon: 'success',
                        title: 'تم إظهار الاختبار',
                        showCancelButton: false,
                        showConfirmButton: false,
                        timer: 2000,
                    }).then(function () {
                        // Update the text of the span element
                        checkbox.closest('.x').find('div').text('ظاهر');
                    });
                } else if (response == "null inputs") {
                    Swal.fire({
                        icon: 'error',
                        title: 'يجب إدخال جميع الخانات',
                        showCancelButton: false,
                        showConfirmButton: false,
                        timer: 2000,
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'حدث خطأ أثناء إظهار الاختبار',
                        showCancelButton: false,
                        showConfirmButton: false,
                        timer: 2000,
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'فشلت الطلب عبر AJAX',
                    showCancelButton: false,
                    showConfirmButton: false,
                    timer: 2000,
                });
            }
        });
    } else {
        $.ajax({
            type: 'POST',
            url: 'quiz_hide.php',
            data: { action: 'hide', name: sname, subj: ssubj },
            success: function (response) {
                response = response.replace("</p>", "");
                if (response == 1) {
                    Swal.fire({
                        icon: 'success',
                        title: 'تم إخفاء الاختبار',
                        showCancelButton: false,
                        showConfirmButton: false,
                        timer: 2000,
                    }).then(function () {
                        // Update the text of the span element
                        checkbox.closest('.x').find('div').text('مخفي');
                    });
                } else if (response == "null inputs") {
                    Swal.fire({
                        icon: 'error',
                        title: 'يجب إدخال جميع الخانات',
                        showCancelButton: false,
                        showConfirmButton: false,
                        timer: 2000,
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'حدث خطأ أثناء إخفاء الاختبار',
                        showCancelButton: false,
                        showConfirmButton: false,
                        timer: 2000,
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'فشلت الطلب عبر AJAX',
                    showCancelButton: false,
                    showConfirmButton: false,
                    timer: 2000,
                });
            }
        });
    }
});

        function deleteQuiz(quizName) {
            // Use SweetAlert for confirmation
            Swal.fire({
                title: 'هل أنت متأكد؟',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'إلغاء',
                confirmButtonText: 'نعم'
            }).then((result) => {
                if (result.isConfirmed) {
                    // User confirmed, proceed with deletion
                    $.ajax({
                        url: 'delete_quiz_ajax.php',
                        type: 'POST',
                        data: {name: quizName},
                        success: function (response) {
                            response = response.replace("</p>", "");

                            // Use SweetAlert for success message
                            Swal.fire({
                                icon: 'success',
                                title: 'تم حذف الاختبار بنجاح!',
                                text: response,
                                confirmButtonColor: '#28a745',
                            }).then(() => {
                                // Remove the deleted quiz from the UI
                                $(`h4:contains('${quizName}')`).closest('.card').remove();
                            });
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        },
                        error: function (error) {
                            console.error('Error:', error);
                        }
                    });
                }
            });
        }
    </script>

    </div>
    </body>
    </html>
    <script src="js/quiz.js?30=x"></script>
    <?php include("script.php"); ?>



    <?php
        }else{ echo 'error';}
} else {
    ?>
    <script>window.location = '/controlpanel';</script>
<?php
}
?>
