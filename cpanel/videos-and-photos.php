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
  <link rel="stylesheet" href="css/AllCss.css" />
  <link rel="stylesheet" href="sub.css">
  <link rel="stylesheet" href="videosandphotos.css">
  <link rel="stylesheet" href="css/all.min.css" />
</head>

<body>
    <div class="main-flex page">
  <?php 
  include("sidebar.php"); 
  session_start(); 
  
  // Check if user is logged in and has admin privileges
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mediaType'])) {
  $mediaType = $_POST['mediaType'];
  $mediaTitle = $_POST['mediaTitle'];
  $mediaDescription = $_POST['mediaDescription'] ?? '';
  $courseCode = $_POST['courseCode'];
  $uploadOk = 1;
  $thumbnail = '';
  
  // Create upload directory if it doesn't exist
  $uploadDir = "uploads/media/";
  if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
  }
  
  // Process based on media type
  if ($mediaType === 'image') {
    $targetFile = $uploadDir . time() . '_' . basename($_FILES["photoFile"]["name"]);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    
    // Check if image file is an actual image
    $check = getimagesize($_FILES["photoFile"]["tmp_name"]);
    if ($check === false) {
      echo "<script>
        Swal.fire({
          title: 'خطأ',
          text: 'الملف المرفوع ليس صورة',
          icon: 'error',
          confirmButtonText: 'حسناً'
        });
      </script>";
      $uploadOk = 0;
    }
    
    // Check file size (5MB limit)
    if ($_FILES["photoFile"]["size"] > 5000000) {
      echo "<script>
        Swal.fire({
          title: 'خطأ',
          text: 'حجم الملف كبير جداً',
          icon: 'error',
          confirmButtonText: 'حسناً'
        });
      </script>";
      $uploadOk = 0;
    }
    
    // Allow only certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
      echo "<script>
        Swal.fire({
          title: 'خطأ',
          text: 'فقط ملفات JPG, JPEG, PNG & GIF مسموح بها',
          icon: 'error',
          confirmButtonText: 'حسناً'
        });
      </script>";
      $uploadOk = 0;
    }
    
    // If everything is ok, try to upload file
    if ($uploadOk) {
      if (move_uploaded_file($_FILES["photoFile"]["tmp_name"], $targetFile)) {
        // Insert into database
        $filename = basename($targetFile);
        $stmt = $MM->prepare("INSERT INTO media (title, description, filename, type, subcode) VALUES (?, ?, ?, 'image', ?)");
        $stmt->bind_param("ssss", $mediaTitle, $mediaDescription, $filename, $courseCode);
        
        if ($stmt->execute()) {
          // Fix: Use window.location.href instead of reload to prevent confirmation loop
          echo "<script>
            Swal.fire({
              title: 'تم بنجاح',
              text: 'تم رفع الصورة بنجاح',
              icon: 'success',
              confirmButtonText: 'حسناً'
            }).then(function() {
              window.location.href = window.location.pathname; // Redirect to same page without POST data
            });
          </script>";
        } else {
          echo "<script>
            Swal.fire({
              title: 'خطأ',
              text: 'حدث خطأ في قاعدة البيانات: " . $MM->error . "',
              icon: 'error',
              confirmButtonText: 'حسناً'
            });
          </script>";
        }
      } else {
        echo "<script>
          Swal.fire({
            title: 'خطأ',
            text: 'حدث خطأ أثناء رفع الملف',
            icon: 'error',
            confirmButtonText: 'حسناً'
          });
        </script>";
      }
    }
  } elseif ($mediaType === 'video') {
    $targetFile = $uploadDir . time() . '_' . basename($_FILES["videoFile"]["name"]);
    $videoFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    
    // Check file size (50MB limit)
    if ($_FILES["videoFile"]["size"] > 50000000) {
      echo "<script>
        Swal.fire({
          title: 'خطأ',
          text: 'حجم الفيديو كبير جداً',
          icon: 'error',
          confirmButtonText: 'حسناً'
        });
      </script>";
      $uploadOk = 0;
    }
    
    // Allow certain file formats
    if ($videoFileType != "mp4" && $videoFileType != "webm" && $videoFileType != "avi" && $videoFileType != "mov") {
      echo "<script>
        Swal.fire({
          title: 'خطأ',
          text: 'فقط ملفات MP4, WebM, AVI & MOV مسموح بها',
          icon: 'error',
          confirmButtonText: 'حسناً'
        });
      </script>";
      $uploadOk = 0;
    }
    
    // Process video thumbnail if provided
    if (isset($_FILES["videoThumbnail"]) && $_FILES["videoThumbnail"]["size"] > 0) {
      $thumbnailFile = $uploadDir . time() . '_thumb_' . basename($_FILES["videoThumbnail"]["name"]);
      $thumbFileType = strtolower(pathinfo($thumbnailFile, PATHINFO_EXTENSION));
      
      // Check if thumbnail is an image
      $check = getimagesize($_FILES["videoThumbnail"]["tmp_name"]);
      if ($check === false) {
        echo "<script>
          Swal.fire({
            title: 'خطأ',
            text: 'ملف الصورة المصغرة غير صالح',
            icon: 'error',
            confirmButtonText: 'حسناً'
          });
        </script>";
        $uploadOk = 0;
      }
      
      // Check thumbnail format
      if ($thumbFileType != "jpg" && $thumbFileType != "png" && $thumbFileType != "jpeg") {
        echo "<script>
          Swal.fire({
            title: 'خطأ',
            text: 'فقط ملفات JPG, JPEG & PNG مسموح بها للصورة المصغرة',
            icon: 'error',
            confirmButtonText: 'حسناً'
          });
        </script>";
        $uploadOk = 0;
      }
      
      // Upload thumbnail
      if ($uploadOk && move_uploaded_file($_FILES["videoThumbnail"]["tmp_name"], $thumbnailFile)) {
        $thumbnail = basename($thumbnailFile);
      }
    }
    
    // If everything is ok, try to upload video
    if ($uploadOk) {
      if (move_uploaded_file($_FILES["videoFile"]["tmp_name"], $targetFile)) {
        // Insert into database
        $filename = basename($targetFile);
        $stmt = $MM->prepare("INSERT INTO media (title, description, filename, thumbnail, type, subcode) VALUES (?, ?, ?, ?, 'video', ?)");
        $stmt->bind_param("sssss", $mediaTitle, $mediaDescription, $filename, $thumbnail, $courseCode);
        
        if ($stmt->execute()) {
          // Fix: Use window.location.href instead of reload to prevent confirmation loop
          echo "<script>
            Swal.fire({
              title: 'تم بنجاح',
              text: 'تم رفع الفيديو بنجاح',
              icon: 'success',
              confirmButtonText: 'حسناً'
            }).then(function() {
              window.location.href = window.location.pathname; // Redirect to same page without POST data
            });
          </script>";
        } else {
          echo "<script>
            Swal.fire({
              title: 'خطأ',
              text: 'حدث خطأ في قاعدة البيانات: " . $MM->error . "',
              icon: 'error',
              confirmButtonText: 'حسناً'
            });
          </script>";
        }
      } else {
        echo "<script>
          Swal.fire({
            title: 'خطأ',
            text: 'حدث خطأ أثناء رفع الفيديو',
            icon: 'error',
            confirmButtonText: 'حسناً'
          });
        </script>";
      }
    }
  }
}
  
  // Handle delete media request
  if (isset($_POST['delete_id'])) {
    $id = $_POST['delete_id'];
    
    // Get media details to delete the file
    $stmt = $MM->prepare("SELECT filename, thumbnail, type FROM media WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
      $filename = $row['filename'];
      $thumbnail = $row['thumbnail'];
      
      // Delete the file
      if (file_exists("uploads/media/" . $filename)) {
        unlink("uploads/media/" . $filename);
      }
      
      // Delete thumbnail if exists
      if (!empty($thumbnail) && file_exists("uploads/media/" . $thumbnail)) {
        unlink("uploads/media/" . $thumbnail);
      }
      
      // Delete from database
      $stmt = $MM->prepare("DELETE FROM media WHERE id = ?");
      $stmt->bind_param("i", $id);
      
      if ($stmt->execute()) {
        echo "<script>
          Swal.fire({
            title: 'تم الحذف',
            text: 'تم حذف الملف بنجاح',
            icon: 'success',
            confirmButtonText: 'حسناً'
          });
        </script>";
      } else {
        echo "<script>
          Swal.fire({
            title: 'خطأ',
            text: 'حدث خطأ أثناء حذف الملف',
            icon: 'error',
            confirmButtonText: 'حسناً'
          });
        </script>";
      }
    }
  }
  ?>
  
    <div class="quest-long-idk">
      <img src="content-and-imgs/template.png" class="HUM" alt="" />
      <div class="where"><span class="text-where">> ControlPanel > Media Management</span></div>
    </div>
  </div>
  
  <div class="rtl" style="direction: rtl;">
    <h3 class="mt-4 mb-4 text-center">إدارة الوسائط</h3>

    <div class="container container-two-mat">
      <div class="cCont" style="display: flex; background-color: var(--hover1); padding: 10px;">
        <button class='btn btn-success ml-auto' id="toggleFormBtn">إضافة فيديو/صورة جديدة</button>
        <button class="btn" onclick="window.location = '/controlpanel';" style="color: var(--main2); background-color: var(--main1);"><i class="fa-solid fa-arrow-left"></i></button>
      </div>

      <!-- Add Media Form -->
      <form id="addMediaForm" method="post" enctype="multipart/form-data">
        <div class="form-group">
          <label for="mediaType" style="margin-top:3px;">نوع الوسيطة :</label><br>
          <div style='display:flex; width:100%; gap:10px;'>
            <div style="color: white;"><input type="radio" name="mediaType" value="video"> فيديو</div>
            <div style="color: white;"><input type="radio" name="mediaType" value="image"> صورة</div>
          </div>
        </div>
        
        <div class="form-group">
          <label for="mediaTitle">العنوان :</label>
          <input type="text" class="form-control" id="mediaTitle" name="mediaTitle" required>
        </div>
        <div class="form-group">
          <label for="mediaDescription">الوصف :</label>
          <input type="text" class="form-control" id="mediaDescription" name="mediaDescription">
        </div>
        <div class="form-group">
          <label for="courseCode">المقرر :</label>
          <select class="form-control" id="courseCode" name="courseCode" required>
            <option value="" selected disabled>اختر المقرر</option>
            <?php
            // Fetch course codes from the database
            $sql = "SELECT code, name FROM subjects";
            $result = $MM->query($sql);
            while($row = $result->fetch_assoc()) {
              echo "<option value='" . $row['code'] . "'>" . $row['name'] . "</option>";
            }
            ?>
          </select>
        </div>

        <div class="media-upload-section" id="imageUploadSection">
          <div class="form-group">
            <label for="photoFile">رفع صورة (JPEG, PNG, GIF)</label>
            <input type="file" class="form-control-file" id="photoFile" name="photoFile" accept="image/*">
          </div>
        </div>

        <div class="media-upload-section" id="videoUploadSection">
          <div class="form-group">
            <label for="videoFile">رفع فيديو (MP4, WebM, AVI, MOV)</label>
            <input type="file" class="form-control-file" id="videoFile" name="videoFile" accept="video/*">
          </div>
          <div class="form-group">
            <label for="videoThumbnail">رفع صورة مصغرة (اختياري)</label>
            <input type="file" class="form-control-file" id="videoThumbnail" name="videoThumbnail" accept="image/*">
          </div>
        </div>

        <div class="form-group text-right">
          <button type="button" class="btn btn-secondary" id="cancelBtn">إلغاء</button>
          <button type="submit" class="btn btn-success" id="addMediaBtn">بدء الرفع</button>
        </div>
      </form>

      <!-- Media Display Section -->
      <div class="settings-container">
        <h4 class="mt-3 mb-3" style="    text-align: justify;
    color: wheat;">الصور المرفوعة</h4>
        <div class="media-grid">
          <?php
          // Fetch images from database
          $sql = "SELECT id, title, description, filename, subcode FROM media WHERE type = 'image' ORDER BY upload_date DESC";
          $result = $MM->query($sql);
          
          if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
              echo '<div class="media-item">
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                    <p class="mb-0 text-right">' . htmlspecialchars($row['title']) . '</p>
                  </div>
                  <div style="gap: 5px;align-items: center;display: flex;justify-content: center;">
                    <a style="width: 50px;margin-left: 0px;height: 33px;" href="#" class="btn btn-primary btn-sm view-btn" data-type="image" data-src="uploads/media/' . $row['filename'] . '">عرض</a>
                    <form method="post" style="display:inline;">
                      <input type="hidden" name="delete_id" value="' . $row['id'] . '">
                      <button style="width: 50px;margin-left: 0px;height: 33px;" type="submit" class="btn btn-danger btn-sm delete-btn">حذف</button>
                    </form>
                  </div>
                </div>
              </div>';
            }
          } else {
            echo '<p class="text-center">لا توجد صور مرفوعة</p>';
          }
          ?>
        </div>
        
        <h4 class="mt-4 mb-3" style="    text-align: justify;
    color: wheat;">الفيديوهات المرفوعة</h4>
        <div class="media-grid">
          <?php
          // Fetch videos from database
          $sql = "SELECT id, title, description, filename, thumbnail, subcode FROM media WHERE type = 'video' ORDER BY upload_date DESC";
          $result = $MM->query($sql);
          
          if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
              echo '<div class="media-item">
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                    <p class="mb-0 text-right">' . htmlspecialchars($row['title']) . '</p>
                  </div>
                  <div style="gap: 5px;align-items: center;display: flex;justify-content: center;">
                    <a style="width: 50px;margin-left: 0px;height: 33px;" href="#" class="btn btn-primary btn-sm view-btn" data-type="video" data-src="uploads/media/' . $row['filename'] . '">عرض</a>
                    <form method="post" style="display:inline;">
                      <input type="hidden" name="delete_id" value="' . $row['id'] . '">
                      <button style="width: 50px;margin-left: 0px;height: 33px;" type="submit" class="btn btn-danger btn-sm delete-btn">حذف</button>
                    </form>
                  </div>
                </div>
              </div>';
            }
          } else {
            echo '<p class="text-center">لا توجد فيديوهات مرفوعة</p>';
          }
          ?>
        </div>
      </div>
    </div>
  </div>

  <?php include("script.php"); ?>
  
  <script>
    $(document).ready(function() {
      $("#addMediaForm").hide();
      $(".media-upload-section").hide();

      $("#toggleFormBtn").on("click", function() {
        $("#addMediaForm").slideToggle('slow');
      });

      $("#cancelBtn").on("click", function() {
        $("#addMediaForm").hide();
        $(".media-upload-section").hide();
        $("input[name='mediaType']").prop('checked', false);
      });

      $("input[name='mediaType']").on('change', function() {
        $(".media-upload-section").hide();
        
        if ($(this).val() === 'image') {
          $("#imageUploadSection").show();
        } else if ($(this).val() === 'video') {
          $("#videoUploadSection").show();
        }
      });
      
      // Handle view button click
      $('.view-btn').on('click', function(e) {
        e.preventDefault();
        
        const src = $(this).data('src');
        const type = $(this).data('type');
        
        if (type === 'image') {
          // Show image using SweetAlert
          Swal.fire({
            imageUrl: src,
            imageAlt: 'Image',
            width: 'auto',
            showCloseButton: true,
            showConfirmButton: false,
            backdrop: 'rgba(0,0,0,0.85)'
          });
        } else if (type === 'video') {
          // Show video using SweetAlert
          Swal.fire({
            html: `<video width="100%" controls autoplay><source src="${src}" type="video/mp4"></video>`,
            width: 'auto',
            showCloseButton: true,
            showConfirmButton: false,
            backdrop: 'rgba(0,0,0,0.85)',
            customClass: {
              popup: 'video-popup'
            }
          });
        }
      });
    });

    function toggleSection(element) {
      element.classList.toggle('active');
      const content = element.nextElementSibling;
      content.classList.toggle('show');
    }
  </script>
</body>
</html>