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
<link rel="stylesheet" href="sub.css?ver=2">
<link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;500;600;800;900;1000&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="css/AllCss.css?ver=1" />
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
            <div class="where"><span class="text-where">> ControlPanel > Material Management</span></div>
            </div>
            </div>
  <div class="rtl" style="direction: rtl;">
  <center> <!-- ودي الcenter رقم 93123 اللي استعملها فحياتي علشان مليش فال فرونت اند الحمدلله إن حجازي موجود -->
    <h2 class="mt-4 mb-4">عرض وتحرير المحاضرات</h2>
  </center><div class="container-two-mat">
  <script>
function uploadFile() {
    var lectt = $("#lectureNumber").val();
    var code = $("#doctorName").val();
    var form = $('#uploadForm')[0];
    var formData = new FormData(form);

    // $.ajax({
    //     url: 'ajax_duplicate_check.php',
    //     type: 'POST',
    //     data: { code: code },
    //     success: function(response) {
    //         response = response.replace("</p>", "");
    //         if (response === "exists") {
    //             Swal.fire({
    //                 title: 'خطأ',
    //                 text: 'المحاضرة موجودة بالفعل',
    //                 icon: 'error',
    //                 confirmButtonText: 'OK'
    //             });
    //         } else if (response === "!exists") {
    //             // Show loading SweetAlert with animated spinner
                Swal.fire({
                    title: 'برجاء الإنتظار جاري رفع الملف ....',
                    imageUrl: 'loading.gif',  // Replace with the actual path to your loading GIF
                    imageAlt: 'جاري الرفع...',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    onBeforeOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    type: 'POST',
                    url: 'upload.php',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(uploadResponse) {
                        // Close loading SweetAlert
                        Swal.close();
                        uploadResponse = uploadResponse.replace("</p>", "");
                        // Display response with SweetAlert
                        Swal.fire({
                            title: uploadResponse.includes('بنجاح') ? 'كلو ميه ميه' : 'فشل :(',
                            text: uploadResponse,
                            icon: uploadResponse.includes('بنجاح') ? 'success' : 'error',
                            showCancelButton: false,
                            showConfirmButton: false,
                            timer: 2000,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        }).then(function () {
                            // Reload the page to refresh the question list
                            location.reload();
                        });
                    }
                });
            // } else {
            //     Swal.fire({
            //         title: 'خطأ',
            //         text: 'حدث خطأ أثناء التحقق من رقم المحاضرة',
            //         icon: 'error',
            //         showCancelButton: false,
            //         showConfirmButton: false,
            //         timer: 2000,
            //         });
            // }
        // },
        // error: function(error) {
        //     alert('Error checking duplicate lecture number.');
        //     console.log(error);
        // }
    // });
}
</script>
<body>
    <div style="margin-top:0;padding:0;" class="container position-relative">
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
      <button id="showUploadFormBtn" class="btn btn-success">إضافة +</button>
      <button class="btn" onclick="window.location = '/controlpanel';" style="color: var(--main2);background-color: var(--main1);"><i class="fa-solid fa-arrow-left"></i></button>
    </div> 
  <div id="uploadFormContainer" class="" style="display: none;">
  <form id="uploadForm" enctype="multipart/form-data">
    <div class="form-group row">
      <label for="doctorName" class="col-sm-3 col-form-label text-right">اسم المقرر</label>
      <div class="col-sm-9">
        <select style="height:50px;" class="form-control" id="doctorName" name="doctorName">
          <!-- Add options dynamically if needed -->
        <?php $num = 0; foreach(mysqli_query($MM,"Select * FROM `subjects`") as $x){ $num++; ?>
        <option value="<?=$x['code']?>"><?=$x['name']?></option>
        <?php }if($num == 0){ ?>
        <option value="nothing">لم يتم العثور علي مقررات</option>
        <?php } ?>
        </select>
      </div>
    </div>
    <div class="form-group row">
      <!-- <label for="lectureNumber" style="height:50px;" class="col-sm-3 col-form-label text-right">رقم المحاضرة</label>
      <div class="col-sm-9">
        <input type="number" class="form-control" id="lectureNumber" name="lectureNumber">
      </div> -->
    </div>
    <div class="form-group row">
      <label for="lectureFile" class="col-sm-3 col-form-label text-right">رفع المحاضرة</label>
      <div class="col-sm-9">
        <input type="file" class="form-control-file" id="lectureFile" name="lectureFile">
      </div>
    </div>
    <div class="form-group row">
      <label for="notes" class="col-sm-3 col-form-label text-right">وصف المحاضرة</label>
      <div class="col-sm-9">
        <textarea class="form-control" id="notes" name="notes"></textarea>
      </div>
    </div>
    <div class="form-group row">
      <div class="col-sm-9 offset-sm-3 text-right">
        <button type="button" class="btn btn-primary" onclick="uploadFile()">إرسال</button>
      </div>
    </div>
  </form>
  <div id="response"></div>
</div>
  <?php
  // Fetch PDF files from the database, ordered by subcode and id
  $fetchQuery = "SELECT * FROM content ORDER BY subcode, id";
  $result = $MM->query($fetchQuery);

  if ($result->num_rows > 0) {
    $currentSubcode = null;
?><br><br>
<?php
    while ($row = $result->fetch_assoc()) {
      $id = $row['id'];
      $note = $row['note'];
      $subcode = $row['subcode'];
      $nn = "SELECT * FROM subjects WHERE `code`='$subcode'";
      $res = $MM->query($nn);
      $ren = $res->fetch_assoc();
      $subcode = $ren['name'];
      $pdfUrl = $row['pdfurl'];

      // Check if a new subject code is encountered
      if ($subcode != $currentSubcode) {
        // Close the previous list if not the first iteration
        if ($currentSubcode !== null) {
          echo '</ul>';
        }

        // Start a new list for the current subject code
        echo '<h3 class="mt-4 text-right">' . $subcode . '</h3>';
        echo '<ul class="list-group">';
        $currentSubcode = $subcode;
      }

      echo '<li class="list-group-item">';
      echo '<div class="d-flex justify-content-between align-items-center">';
      echo '<div>';
      echo '<p class="mb-0 text-right"> وصف المحاضرة : <strong>' . $note . '</strong></p>';
      echo '</div>';
      echo '<div style="gap: 5px;align-items: center;display: flex;justify-content: center;">';
      echo '<a style="width: 50px;margin-left: 0px;height: 33px;" href="' . $pdfUrl . '" class="btn btn-primary btn-sm" target="_blank">عرض</a>';
      echo '<button style="width: 50px;margin-left: 0px;height: 33px;" class="btn btn-danger btn-sm delete-btn" data-subcode= "' . $subcode . '" data-id= "' . $id . '"data-pdfurl="' . $pdfUrl . '">حذف</button>';
      echo '</div>';
      echo '</div>';
      echo '</li>';
    }

    // Close the last list
    echo '</ul>';
  } else {
    echo '<p class="text-muted text-right">لا توجد محاضرات لعرضها حالياً.</p>';
  }

  // Close the MySQL connection
  $MM->close();
  ?>

</div>

<script>
  $("#uploadForm").hide();
  $(document).ready(function() {
      $('#showUploadFormBtn').click(function() {
        $("#uploadForm").show();
        $('#uploadFormContainer').slideToggle('slow'); // Toggle the upload form visibility with animation
      });
    });
// Handle delete button click using SweetAlert for confirmation
$('.delete-btn').click(function() {
  var pdfUrlToDelete = $(this).data('pdfurl');
  var id = $(this).data('id');
  var subcode = $(this).data('subcode');
  
  // Show confirmation alert before proceeding with deletion
  Swal.fire({
    title: 'هل أنت متأكد؟',
    text: 'سيتم حذف هذه المحاضرة نهائياً!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'نعم، حذف',
    cancelButtonText: 'إلغاء'
  }).then((result) => {
    if (result.isConfirmed) {
      // Proceed with the deletion using AJAX
      $.ajax({
        url: 'delete_mat_ajax.php',
        type: 'POST',
        data: { pdfurl: pdfUrlToDelete, Subcode: subcode, Id: id},
        success: function(response) {
          // Remove </p> tag from the response
          response = response.replace("</p>", "");
          
          // Display success message using SweetAlert
          Swal.fire({
            icon: 'success',
            title: 'تم الحذف بنجاح!',
            showCancelButton: false,
            showConfirmButton: false,
            timer: 2000,
            text: response,
          }).then(() => {
            // Refresh the list after successful deletion
            location.reload();
          });
        },
        error: function(error) {
          // Display error message using SweetAlert
          Swal.fire({
            icon: 'error',
            title: 'خطأ',
            showCancelButton: false,
            showConfirmButton: false,
            timer: 2000,
            text: 'حدث خطأ أثناء إجراء العملية.',
          });
          console.log(error);
        }
      });
    }
  });
});
</script>
<?php include("script.php"); ?>

</body>
</html>

<?php } else {
    ?>
    <script>window.location = '/controlpanel';</script>
<?php
} ?>
