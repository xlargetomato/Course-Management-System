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
  <link rel="stylesheet" href="assignment.css">
  <link rel="stylesheet" href="css/AllCss.css" />
  <link rel="stylesheet" href="css/all.min.css" />
  <style>
    .editor-toolbar {
      padding: 8px;
      background-color: #f5f5f5;
      border: 1px solid #ddd;
      border-bottom: none;
      border-radius: 4px 4px 0 0;
      display: flex;
      flex-wrap: wrap;
      gap: 2px;
      align-items: center;
    }

    .editor-toolbar button {
      margin-right: 2px;
    }

    .editor-toolbar .divider {
      margin: 0 5px;
      color: #ccc;
    }

    .color-dropdown {
      padding: 5px;
      min-width: 100px;
      display: flex;
      flex-wrap: wrap;
      gap: 5px;
      display:none;
    }

    .color-btn {
      width: 20px;
      height: 20px;
      border: 1px solid #ddd;
      border-radius: 4px;
      cursor: pointer;
    }

    .color-btn:hover {
      transform: scale(1.1);
      box-shadow: 0 0 3px rgba(0,0,0,0.3);
    }

    #editor {
      border-top-left-radius: 0;
      border-top-right-radius: 0;
      padding: 10px;
      overflow-y: auto;
      min-height: 200px;
    }

    #editor:focus {
      outline: none;
      border-color: #80bdff;
      box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    
    .cCont {
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
  <div class="where"><span class="text-where">> ControlPanel > Assignments Management</span></div>
</div>
</div>
<div class="rtl" style="direction: rtl;">
<body id="assignment">
<center>
  <h2 class="mt-4 mb-4">عرض وتحرير التكليفات</h2>
</center>
<div class="container">
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
        <label for="week" class="text-right">الأسبوع :</label>
        <select class="form-control" id="week" name="week" required>
          <option value="الأول">الأول</option>
          <option value="الثاني">الثاني</option>
          <option value="الثالث">الثالث</option>
          <option value="الرابع">الرابع</option>
          <option value="الخامس">الخامس</option>
          <option value="السادس">السادس</option>
          <option value="السابع">السابع</option>
          <option value="الثامن">الثامن</option>
          <option value="التاسع">التاسع</option>
          <option value="العاشر">العاشر</option>
          <option value="الحادي عشر">الحادي عشر</option>
          <option value="الثاني عشر">الثاني عشر</option>
        </select>
      </div>
      <div class="form-group">
        <label for="typeSelect" class="text-right">النوع :</label>
        <select class="form-control" id="typeSelect" name="type" required>
          <option value="0">نظري</option>
          <option value="1">عملي</option>
        </select>
      </div>
      <div class="form-group">
        <label for="content" class="text-right">شرح التكليف :</label>
        <div class="editor-toolbar">
          <!-- Text Formatting -->
          <button type="button" class="btn btn-sm btn-light" onclick="formatText('bold')" title="Bold"><i class="fas fa-bold"></i></button>
          <button type="button" class="btn btn-sm btn-light" onclick="formatText('italic')" title="Italic"><i class="fas fa-italic"></i></button>
          <button type="button" class="btn btn-sm btn-light" onclick="formatText('underline')" title="Underline"><i class="fas fa-underline"></i></button>
          <span class="divider">|</span>
          
          <!-- Text Alignment -->
          <button type="button" class="btn btn-sm btn-light" onclick="formatText('justifyRight')" title="Align Right"><i class="fas fa-align-right"></i></button>
          <button type="button" class="btn btn-sm btn-light" onclick="formatText('justifyCenter')" title="Align Center"><i class="fas fa-align-center"></i></button>
          <button type="button" class="btn btn-sm btn-light" onclick="formatText('justifyLeft')" title="Align Left"><i class="fas fa-align-left"></i></button>
          <span class="divider">|</span>
          
          <!-- Special Formatting -->
          <button type="button" class="btn btn-sm btn-light" onclick="formatText('insertHorizontalRule')" title="Horizontal Line"><i class="fas fa-minus"></i></button>
          <button type="button" class="btn btn-sm btn-light" onclick="formatHeading('h2')" title="Heading"><i class="fas fa-heading"></i></button>
          <button type="button" class="btn btn-sm btn-light" onclick="formatText('removeFormat')" title="Clear Formatting"><i class="fas fa-eraser"></i></button>
          <span class="divider">|</span>
          
          <!-- Text Color -->
          <div class="dropdown d-inline-block">
            <button class="btn btn-sm btn-light dropdown-toggle" type="button" id="textColorDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Text Color">
              <i class="fas fa-font" style="color: #007bff;"></i>
            </button>
            <div class="dropdown-menu color-dropdown" aria-labelledby="textColorDropdown">
              <button class="color-btn" style="background-color: #000000;" onclick="setTextColor('#000000')"></button>
              <button class="color-btn" style="background-color: #FF0000;" onclick="setTextColor('#FF0000')"></button>
              <button class="color-btn" style="background-color: #008000;" onclick="setTextColor('#008000')"></button>
              <button class="color-btn" style="background-color: #0000FF;" onclick="setTextColor('#0000FF')"></button>
              <button class="color-btn" style="background-color: #800080;" onclick="setTextColor('#800080')"></button>
              <button class="color-btn" style="background-color: #FFA500;" onclick="setTextColor('#FFA500')"></button>
            </div>
          </div>
          
          <!-- Insert Link -->
          <button type="button" class="btn btn-sm btn-light" onclick="insertLink()" title="Insert Link"><i class="fas fa-link"></i></button>
        </div>
        <div id="editor" class="form-control" contenteditable="true" style="min-height: 150px; direction: rtl; text-align: right;"></div>
        <textarea id="content" name="content" style="display: none;"></textarea>
      </div>
      <button type="button" class="btn btn-primary" onclick="saveAssignment()">حفظ</button>
    </form>
  </div>
  <br>
  <!-- Existing assignments display -->
  <div id="assignmentsList"></div>
</div>

<script>
// Basic formatting function
function formatText(command) {
  document.execCommand(command, false, null);
  document.getElementById('editor').focus();
  
  // Update the hidden textarea with the HTML content
  document.getElementById('content').value = document.getElementById('editor').innerHTML;
}

// Function to set text color
function setTextColor(color) {
  document.execCommand('foreColor', false, color);
  document.getElementById('editor').focus();
  document.getElementById('content').value = document.getElementById('editor').innerHTML;
}

// Function to set background color
function setBackgroundColor(color) {
  document.execCommand('hiliteColor', false, color);
  document.getElementById('editor').focus();
  document.getElementById('content').value = document.getElementById('editor').innerHTML;
}

// Function to insert a link
function insertLink() {
  var url = prompt('أدخل رابط URL:', 'http://');
  if (url) {
    document.execCommand('createLink', false, url);
    document.getElementById('editor').focus();
    document.getElementById('content').value = document.getElementById('editor').innerHTML;
  }
}

// Function to insert heading
function formatHeading(tag) {
  document.execCommand('formatBlock', false, tag);
  document.getElementById('editor').focus();
  document.getElementById('content').value = document.getElementById('editor').innerHTML;
}

// Function to delete the weekly assignment
function deleteAssignment(assignmentId) {
  Swal.fire({
    title: 'هل أنت متأكد؟',
    text: "لن يمكنك استعادة هذا التكليف بعد الحذف!",
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
        url: 'delete_weekly_assignment.php',
        type: 'POST',
        data: { assignmentId: assignmentId },
        success: function(response) {
          response = response.replace("</p>", "");
          switch (response) {
            case "success":
              Swal.fire({
                icon: 'success',
                title: 'تم حذف التكليف بنجاح',
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
    url: 'fetch_weekly_assignments.php',
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

// Function to save the weekly assignment
function saveAssignment() {
  // Make sure the hidden textarea has the latest content
  document.getElementById('content').value = document.getElementById('editor').innerHTML;
  
  var subject = $('#subjectSelect').val();
  var week = $('#week').val();
  var content = $('#content').val();
  var type = $('#typeSelect').val();

  // Additional validation if needed

  // AJAX to save the assignment
  $.ajax({
    url: 'add_weekly_assignment.php',
    type: 'POST',
    data: { subject: subject, week: week, content: content, type: type },
    success: function(response) {
      // Remove </p> tag from the response
      response = response.replace("</p>", "");
      // Display success message
      switch (response) {
        case "success":
          Swal.fire({
            icon: 'success',
            title: 'تم إضافة التكليف بنجاح',
            showCancelButton: false,
            showConfirmButton: false,
            timer: 2000,
          }).then(() => {
            // Refresh the form and assignments list
            $('#editWeeklyForm')[0].reset();
            document.getElementById('editor').innerHTML = '';
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
        case "Assignment for this subject already exists.":
          Swal.fire({
            icon: 'error',
            title: 'حدث خطأ أثناء الحفظ',
            text: 'يوجد بالفعل تكليف لهذا المقرر',
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

// Initialize tooltips and event listeners when the document is loaded
document.addEventListener('DOMContentLoaded', function() {
  document.getElementById('editor').addEventListener('input', function() {
    document.getElementById('content').value = this.innerHTML;
  });
  
  // Initialize tooltips if using Bootstrap
  $('[data-toggle="tooltip"]').tooltip();
});
</script>

</body>
</html>
<?php include("script.php"); ?>

<?php } else {
    ?>
    <script>window.location = '/controlpanel';</script>
<?php
} ?>