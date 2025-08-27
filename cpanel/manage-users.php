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
    <link rel="stylesheet" href="css/AllCss.css" />
    <link rel="stylesheet" href="manage-users.css" />
    <link rel="stylesheet" href="css/all.min.css" />
</head>
<div class="main-flex page">
<?php
include("sidebar.php");
session_start();
if ($_SESSION["level"] >= "3") {
    ?>
    <style>

    </style>
<body>
<div class="quest-long-idk">
            <img src="content-and-imgs/template.png" class="HUM" alt="" />
            <div class="where"><span class="text-where">> ControlPanel > Users Management</span></div>
            </div>
            </div>
  <div class="rtl" style="direction: rtl;">
    <center> <!-- معلش بستعمل center كتير بقى -->
        <h2 class="mt-4 mb-4">إدارة المستخدمين</h2>
    </center>
<div class="container">
    <!-- إضافة button -->
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
        <button href='add-user' class='bnn btn btn-success'> + إضافة</button>
        <button class="btn" onclick="window.location = '/controlpanel';" style="color: var(--main2);background-color: var(--main1);"><i class="fa-solid fa-arrow-left"></i></button>
    </div>

    <div class="action-buttons2 mb-4">
            <!-- Add User Form -->
            <div style="display: none;" class="hide">
    <form id="addUserForm" >
        <div class="form-group">
            <label for="addUsername">اسم المستخدم:</label>
            <input type="text" class="form-control" id="addUsername" name="addUsername">
        </div>
        <div class="form-group">
            <label for="addName">الاسم:</label>
            <input type="text" class="form-control" id="addName" name="addName">
        </div>
        <div class="form-group">
            <label for="addPassword">كلمة السر:</label>
            <input type="password" class="form-control" id="addPassword" name="addPassword">
        </div>
        <div class="form-group">
            <label for="addLevel">مستوى الصلاحية:</label>

            <select class="form-control" id="addLevel" name="addLevel">
                <?php if($_SESSION['level'] == 4){ echo '<option value="3">Head Admin</option>';} ?>
                <option value="2">Admin</option>
                <option value="1">Mod</option>
            </select>
            
        </div>
    </form>
    <button class="btn btn-success add-btn">إضافة المستخدم</button>
    </div>
    </div>

    <?php
    $fetchQuery = "SELECT * FROM usr";
    $result = $MM->query($fetchQuery);

    if ($_SESSION['level'] == 4) {
        $matches = [1, 2, 3];
    } else {
        $matches = [1, 2];
    }
    

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if (in_array($row['level'], $matches)) {
                ?>
                <div class="card user-card">
                    <h5 class="card-title"><strong>اسم المستخدم : </strong><?php echo $row['username']; ?></h5>
                    <p class="card-text"><strong>الاسم : </strong><?php echo $row['name']; ?></p>
                    <p class="card-text"><strong>الصلاحية : </strong><?php if($row['level'] == 3){ echo 'Head Admin'; }elseif($row['level'] == 2){echo "Admin";}else{echo "Mod";} ?></p>
                    <div class="action-buttons">
                        <button class='btn btn-primary edit-form-btn' data-password="<?=$row['password']?>" data-name="<?=$row['name']?>" data-level="<?=$row['level']?>" data-username="<?= str_replace(' ', '-', $row['username']); ?>">تحرير</button>
                        <button class='btn btn-danger delete-btn' data-username="<?php echo $row['username']; ?>">حذف</button>
                    </div>

                    <!-- Edit Form -->
                    <form id="editForm-<?= str_replace(' ', '-', $row['username']); ?>" method="post" style="display: none;">
                        <div class="form-group">
                            <label for="editUsername">اسم المستخدم:</label>
                            <input type="text" class="form-control" value="<?=$row['username']?>" id="editUsername" name="editUsername">
                            <input type="text" class="form-control" style="display:none;margin-top:10px;" value="<?=$row['username']?>" id="curUsername" name="curUsername"> <!-- using it for the query of the database  -->
                        </div>
                        <div class="form-group">
                            <label for="editName">الاسم:</label>
                            <input type="text" class="form-control" id="editName" name="editName">
                        </div>
                        <div class="form-group">
                            <label for="editPassword">كلمة السر:</label>
                            <input type="password" class="form-control" id="editPassword" name="editPassword">
                        </div>
                        <div class="form-group">
                        <label for="editLevel">مستوى الصلاحية:</label>
                            <select class="form-control" id="editLevel" name="editLevel">
                                <?php if($_SESSION['level'] == 4){ echo '<option value="3">Head Admin</option>';} ?>
                                <option value="2">Admin</option>
                                <option value="1">Mod</option>
                            </select>
                            <!-- <input type="number" min="1" max="2" class="form-control" id="editLevel" name="editLevel"> -->
                        </div>
                        <button class="btn btn-primary sub" data-username="<?= str_replace(' ', '-', $row['username']); ?>">حفظ التغييرات</button>

                    </form>
                </div>
                <?php
            }
        }
    } else {
        echo "<p class='text-muted text-center'>لا يوجد مستخدمين حالياً.</p>";
    }
    $MM->close();
    ?>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


<!-- jQuery for AJAX and toggling edit form visibility -->
<script>
    // Show the add user form when the "+ إضافة" button is clicked
    $(".bnn").click(function () {
        $(".hide").slideToggle('slow');
    });

    // AJAX for adding user
    $(".add-btn").on("click", function (event) {
        // Prevent the default button action
        event.preventDefault();
        // Get form data
        var formData = $("#addUserForm").serializeArray();
        var level = parseInt($("#addLevel").val()); // Parse to ensure it's an integer
        var username = $("#addUsername").val();
        var name = $("#addName").val();
        var password = $("#addPassword").val();
        if(username.length >= 4 && password.length >= 6 && name.length >= 4){
        if (level === 1 || level === 2 || level === 3) {
        // Send AJAX request to add-user.php
        $.ajax({
            type: "POST",
            url: "add-user.php", // Update with the correct path to your PHP file
            data: formData,
            success: function (response) {
                response = response.replace("</p>", "");
                // Handle the response (you may show a success message or perform any other action)
                Swal.fire({
                    title: response.includes('بنجاح') ? 'تمت الإضافة بنجاح' : 'فشل :(',
                    text: response,
                    icon: response.includes('بنجاح') ? 'success' : 'error',
                    showCancelButton: false,
                    showConfirmButton: false,
                    timer: 2000,
                });
                setTimeout(() => {  location.reload(); }, 2000);                
            },
            error: function (error) {
                // Handle the error
                console.log("Error:", error);
            }
        });
    } else {
                Swal.fire({
                    title: 'فشل :(',
                    text: 'مستوى الصلاحية خاطيء',
                    icon: 'error',
                    showCancelButton: false,
                    showConfirmButton: false,
                    timer: 2000,
                });
    }
}else{
    Swal.fire({
                    title: 'فشل :(',
                    html: 'يوجد بضعة شروط لإضافة مستخدم : <br> - أسم المستخدم لا يقل عن 4 أحرف <br> - الأسم لا يقل عن 4 أحرف <br> - كلمة السر لا تقل عن 6 أحرف',
                    icon: 'error',
                    showCancelButton: false,
                    showConfirmButton: false,
                    timer: 2000,
                });
}
    });
</script>
<!-- AJAX for deleting user -->
<script>
    $(".delete-btn").on("click", function (event) {
        // Prevent the default button action
        event.preventDefault();

        // Get the username to be deleted
        var username = $(this).data("username").replace(/-/g, " ") // Replace spaces with underscores
        var userCard = $("#editForm-" + username).closest('.user-card'); // Find the parent user card

        // Confirm deletion with user
        Swal.fire({
            title: 'هل أنت متأكد أنك تريد حذف هذا المستخدم؟',
            text: 'لن يكون بإمكانك التراجع عن هذا الإجراء!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'نعم، قم بالحذف!',
            cancelButtonText: 'إلغاء'
        }).then((result) => {
            if (result.isConfirmed) {
                // Send AJAX request to delete-user.php
                $.ajax({
                    type: "POST",
                    url: "delete-user.php", // Update with the correct path to your PHP file
                    data: { username: username },
                    success: function (response) {
                        response = response.replace("</p>", "");
                        // Handle the response (you may show a success message or perform any other action)
                        Swal.fire({
                            title: response.includes('بنجاح') ? 'تم الحذف بنجاح' : 'فشل :(',
                            text: response,
                            icon: response.includes('بنجاح') ? 'success' : 'error',
                            showCancelButton: false,
                            showConfirmButton: false,
                            timer: 2000,
                        });

                        // Optionally, you can remove the deleted user card from the UI
                        userCard.remove();
                    },
                    error: function (error) {
                        // Handle the error
                        console.log("Error:", error);
                    }
                });
            }
        });
    });
</script>
<script>
    $(document).ready(function () {
        // Toggle the edit form when any "تحرير" (Edit) button is clicked
        $(".edit-form-btn").click(function () {
            var username = $(this).data("username").replace(/ /g, "-"); // Replace spaces with underscores
            var name = $(this).data("name");
            var password = $(this).data("password");
            var level = $(this).data("level");
            var editForm = $("#editForm-" + username);
            var username = $(this).data("username").replace(/-/g, " "); // Replace spaces with underscores

            // Populate the form fields with user data
            editForm.find("#editUsername").val(username);
            editForm.find("#editName").val(name);
            editForm.find("#editPassword").val(password);
            editForm.find("#editLevel").val(level);
            // Toggle the edit form visibility
            editForm.toggle();
        });

        // AJAX for updating user information
        $(".sub").on("click", function (event) {
            // Prevent the default form submission
            event.preventDefault();

            // Get form data
            var form = $("#editForm-" + $(this).data("username"));
            var formData = form.serializeArray();
            var level = parseInt(form.find("#editLevel").val()); // Parse to ensure it's an integer

            // Check if the user level is 1 or 2 before sending the update request
            if (level === 1 || level === 2 || level == 3) {
                $.ajax({
                    type: "POST",
                    url: "edit-user.php", // Update with the correct path to your PHP file
                    data: formData,
                    success: function (response) {
                        response = response.replace("</p>", "");
                        // Handle the response (you may show a success message or perform any other action)
                        Swal.fire({
                            title: response.includes('بنجاح') ? 'كلو ميه ميه' : 'فشل :(',
                            text: response,
                            icon: response.includes('بنجاح') ? 'success' : 'error',
                            showCancelButton: false,
                            showConfirmButton: false,
                            timer: 2000,
                        });
                        setTimeout(() => {  location.reload(); }, 2000);                
                    },
                    error: function (error) {
                        // Handle the error
                        console.log("Error:", error);
                    }
                });
            } else {
                Swal.fire({
                    title: 'فشل :(',
                    text: 'مستوى الصلاحية خاطيء',
                    icon: 'error',
                    showCancelButton: false,
                    showConfirmButton: false,
                    timer: 2000,
                });
            }
        });
    });
</script>

</body>
</html><?php include("script.php"); ?>


<?php
} else {
    ?>
    <script>window.location = '/controlpanel';</script>
<?php }
?>
