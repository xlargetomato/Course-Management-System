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
<link rel="stylesheet" href="quiz.css">
<link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;500;600;800;900;1000&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="css/AllCss.css" />
    <link rel="stylesheet" href="css/all.min.css" />
</head>
<div class="main-flex page">
<?php
session_start();
include("sidebar.php");

if ($_SESSION["level"] != "") {
?>
<div class="quest-long-idk">
            <img src="content-and-imgs/template.png" class="HUM" alt="" />
            <div class="where"><span class="text-where">> ControlPanel > Quiz Management > Quiz creation</span></div>
            </div>
            </div>
  <div class="rtl" style="direction: rtl;">

<script>
    function submitForm() {
    var selectedSubject = document.getElementById("subj").value;
    var quizName = document.getElementById("name").value;

    if (selectedSubject && quizName) {
        window.location.href = "quiz-manage?subj=" + encodeURIComponent(selectedSubject) + "&name=" + encodeURIComponent(quizName) +"&from=step1";
    } else {
        alert("يرجى اختيار المقرر وإدخال اسم الاختبار");
    }
}
</script>
<body>
    <h2 class="mt-4 mb-4" style="text-align: center;">اختيار المقرر واسم الاختبار</h2>

    <div class="container">
        <style>
            .cCont{
            background-color: var(--hover1);
            display: flex;
            justify-content: left;
            margin-bottom: 20px;
            }
            .cCont > button {
            margin: 10px;
            text-align: center;
            }
        </style>
        <div class="cCont">
            <button class="btn" onclick="window.location = '/cpanel/quiz';" style="color: var(--main2);background-color: var(--main1);"><i class="fa-solid fa-arrow-left"></i></button>
        </div>
        <label style="display: block;text-align:right;" for="subj">اختر المقرر :</label>
        <select class="form-control" id="subj" name="subj" required>
        <option disabled selected value="">اسم المقرر</option>
            <?php
            $subjects = mysqli_query($MM, "SELECT * FROM `subjects`");
            foreach ($subjects as $subject) {
                echo "<option value='" . $subject['name'] . "'>" . $subject['name'] . "</option>";
            }
            ?>
        </select>
        <div id="hidden"><br>
        <label style="display: block;text-align:right;" for="name">اسم الاختبار :</label>
        <input type="text" class="form-control" id="name" name="quizName" required>

        <div class="btn-container">
            <button type="button" class="btn btn-primary" onclick="submitForm()">التالي</button>
        </div>
        </div>
    </div>
</body>

<script>
    $(document).ready(function () {
        $('#hidden').hide();

        $('#subj').on('change', function () {
            $('#hidden').show();
        });
    });
</script>
<?php include("script.php"); ?>

</body>
</html>
<?php
} else {
    ?>
    <script>window.location = '/controlpanel';</script>
<?php
}
?>
