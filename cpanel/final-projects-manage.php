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
    <link
      href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;500;600;800;900;1000&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="assignment.css">

    <link rel="stylesheet" href="css/AllCss.css" />
    <link rel="stylesheet" href="css/all.min.css" />
</head>
<div class="main-flex page">
<?php 
include("sidebar.php");
session_start();
if($_SESSION["level"] > 1){
?>
<body>
<div class="quest-long-idk">
            <img src="content-and-imgs/template.png" class="HUM" alt="" />
            <div class="where"><span class="text-where">> ControlPanel > Final Projects Management</span></div>
            </div>
            </div>
  <div class="rtl" style="direction: rtl;">
<body id="assignment">
<center> <!-- وده كومنت ملهوش لازمة بس علشان الcenter دي متزعلش -->
  <h2 class="mt-4 mb-4">عرض وتحرير المشاريع النهائية</h2>
</center>
<div class="container">
  <style>
        .cCont{
        background-color: var(--hover1);
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
        }
        .cCont > button {
        margin: 10px;
        text-align: center;
        }
    </style>
    <div class="cCont">
      <button class="btn btn-success" onclick="toggleForm()">إضافة +</button>
      <button class="btn" onclick="window.location = '/controlpanel';" style="color: var(--main2);background-color: var(--main1);"><i class="fa-solid fa-arrow-left"></i></button>
    </div>
  <div class="form-container">
    <form id="editWeeklyForm">
      <div class="form-group">
        <label for="subjectSelect" class="text-right">اسم المقرر :</label>
        <select class="form-control" id="subjectSelect" name="subject" required>
          <!-- Options will be dynamically added here using JavaScript -->
        </select>
      </div>
      <div class="form-group">
        <label for="content" class="text-right">شرح المشروع :</label>
        <textarea class="form-control" id="content" name="content" rows="3" required></textarea>
      </div>
      <button type="button" class="btn btn-primary" onclick="saveAssignment()">حفظ</button>
    </form>
  </div>
<br>
  <!-- Existing assignments display -->
  <div id="assignmentsList"></div>

</div>

<script>
// Function to delete the weekly assignment
function deleteAssignment(assignmentId) {
  Swal.fire({
    title: 'هل أنت متأكد؟',
    text: "لن يمكنك استعادة هذا المشروع بعد الحذف!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'نعم، احذفه!',
    cancelButtonText:'إلغاء'
  }).then((result) => {
    if (result.isConfirmed) {
      // AJAX to delete the assignment
      $.ajax({
        url: 'delete_final_project.php',
        type: 'POST',
        data: { assignmentId: assignmentId },
            success: function(response) {
            response = response.replace("</p>", "");
                switch (response) {
                case "success":
                    Swal.fire({
                    icon: 'success',
                    title: 'تم حذف المشروع بنجاح',
                    showCancelButton: false,
                    showConfirmButton: false,
                    timer: 2000,
                    }).then(() => {
                    // Refresh the assignments list
                    fetchAssignments();
                    });
                    break;
                default:
                    Swal.fire({
                    icon: 'error',
                    title: 'حدث خطأ أثناء الحذف',
                    text: 'برجاء المحاولة مرة أخرى',
                    showCancelButton: false,
                    showConfirmButton: false,
                    timer: 2000,
                    });
                    break;
                }
            }
            });
        }
        });
}
    
// Function to toggle the visibility of the form
function toggleForm() {
  $('.form-container').slideToggle('slow');
}

// Function to fetch and display existing assignments
function fetchAssignments() {
  $.ajax({
    url: 'fetch_final_projects.php',
    type: 'GET',
    success: function(response) {
      $('#assignmentsList').html(response);
    },
    error: function(error) {
      alert("حدث خطأ أثناء جلب البيانات.");
      console.log(error);
    }
  });
}

// Initial fetch and display
fetchAssignments();

// Function to fetch subjects and populate the select options
function fetchSubjects() {
  $.ajax({
    url: 'fetch_subjects.php',
    type: 'GET',
    success: function(response) {
      $('#subjectSelect').html(response);
    },
    error: function(error) {
      alert("حدث خطأ أثناء جلب البيانات.");
      console.log(error);
    }
  });
}

// Initial fetch subjects
fetchSubjects();

// Function to save the final project
function saveAssignment() {
  var subject = $('#subjectSelect').val();
  var content = $('#content').val();

  // Additional validation if needed

  // AJAX to save the assignment
  $.ajax({
    url: 'add_final_project.php',
    type: 'POST',
    data: { subject: subject, content: content },
    success: function(response) {

      // Remove </p> tag from the response
      response = response.replace("</p>", "");
      // Display success message
      switch (response) {
        case "success":
          Swal.fire({
            icon: 'success',
            title: 'تم إضافة المشروع بنجاح',
            showCancelButton: false,
            showConfirmButton: false,
            timer: 2000,
          }).then(() => {
            // Refresh the form and assignments list
            $('#editWeeklyForm')[0].reset();
            fetchAssignments();
          });
          break;
        case "Missing information.":
          Swal.fire({
            icon: 'error',
            title: 'حدث خطأ أثناء الحفظ',
            text: 'برجاء إدخال جميع الخانات',
            showCancelButton: false,
            showConfirmButton: false,
            timer: 2000,
          });
          break;
        case "Final project for this subject already exists.":
            Swal.fire({
            icon: 'error',
            title: 'حدث خطأ أثناء الحفظ',
            text: 'يوجد بالفعل المشروع لهذا المقرر',
            showCancelButton: false,
            showConfirmButton: false,
            timer: 2000,
          });
          break;
        default:
          Swal.fire({
            icon: 'error',
            title: 'حدث خطأ أثناء الحفظ',
            text: 'برجاء المحاولة مرة أخرى',
            showCancelButton: false,
            showConfirmButton: false,
            timer: 2000,
          });
          break;
      }
    }
  });
}
</script>

</body>
</html>
<?php include("script.php"); ?>

<?php } else {
    ?>
    <script>window.location = '/controlpanel';</script>
<?php
} ?>


