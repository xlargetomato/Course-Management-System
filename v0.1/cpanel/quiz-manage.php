<?php
include("sql.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
if ($_SESSION["level"] != "") {
    ?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صفحة الاختبار</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
    <style>
        .card {
            border: 1px solid #dee2e6;
            border-radius: 5px;
            margin: 10px;
            padding: 15px;
            max-width: 300px;
        }

        .add-btn {
            margin-top: 10px;
        }
    </style>
</head>
<body class="container" style="text-align:right;">

<?php
if (isset($_GET['subj']) && isset($_GET['name'])) {
    $subj = $_GET['subj'];
    $_SESSION['subj'] = $_GET['subj'];
    $name = $_GET['name'];
    $_SESSION['name'] = $_GET['name'];

    $stmt = $MM->prepare("SELECT * FROM quiz WHERE subj = ? AND name = ?");
    $stmt->bind_param("ss", $subj, $name);
    $stmt->execute();
    $result = $stmt->get_result();
?>

    <h1 class="mt-4 mb-4">قائمة الأسئلة</h1>
    <button class="btn btn-success add-btn" data-toggle="modal" data-target="#exampleModalCenter" onclick="showAddForm()">إضافة سؤال جديد</button>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <div class="card">
            <p><strong>السؤال :</strong> <?php echo $row['ques']; ?></p>
            <button class="btn btn-warning edit-btn" data-toggle="modal" data-target="#editModalCenter" onclick='showEditForm("<?=$row["id"]?>","<?=$row["type"]?>","<?=$row["ques"]?>","<?=$row["opt1"]?>","<?=$row["opt2"]?>","<?=$row["opt3"]?>","<?=$row["opt4"]?>","<?=$row["ans"]?>","<?php if($row["corr"] != "null"){ echo $row["corr"];}else{echo "null";} ?>")'>تعديل</button><br>
            <button class="btn btn-danger delete-btn" data-question-id="<?php echo $row['id']; ?>">حذف</button>
        </div>
    <?php } ?>
    <!-- Add Question Form Popup -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">إضافة سؤال</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" style="text-align:right;">
        <form id="question-form">
            <div class="form-group">
                <label for="ques">السؤال:</label>
                <input type="text" class="form-control" name="ques" required>
            </div>

            <lable>نوع السؤال :</label><br><br>
            <input type="radio" name="type" value="trueOrFalse" class="trueOrFalse" id="type" required>&nbsp;&nbsp;&nbsp;صح وغلط
            <br><br>
            <input type="radio" name="type" value="choose" class="choose" id="type" required>&nbsp;&nbsp;&nbsp;اختيار من متعدد 
            <br>
         <div id="form2">
            <div class="form-group"><br>
                <input type="radio" name="Tru" value="true" class="true" id="tru" class="form-check-input" required>&nbsp;&nbsp;&nbsp;
                <label>صح</label>&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" name="Tru" value="false" class="false" id="false" class="form-check-input" required>&nbsp;&nbsp;&nbsp;
                <label>خطأ</label>
            </div>
    </div>
            <div id="form1">
            <div class="form-group"><br>
                <input type="radio" name="ans" id="ans" value="opt1" class="form-check-input" required>&nbsp;&nbsp;&nbsp;
                <label>الخيار 1:</label>
                <input type="text" class="form-control" id="opt1" name="opt1" required>
            </div>

            <div class="form-group">
                <input type="radio" name="ans" id="ans" value="opt2" class="form-check-input" required>&nbsp;&nbsp;&nbsp;
                <label>الخيار 2:</label>
                <input type="text" class="form-control" id="opt2" name="opt2" required>
            </div>

            <div class="form-group">
                <input type="radio" name="ans" id="ans" value="opt3" class="form-check-input" required>&nbsp;&nbsp;&nbsp;
                <label>الخيار 3:</label>
                <input type="text" class="form-control" id="opt3" name="opt3" required>
            </div>

            <div class="form-group">
                <input type="radio" name="ans" id="ans" value="opt4" class="form-check-input" required>&nbsp;&nbsp;&nbsp;
                <label>الخيار 4:</label>
                <input type="text" class="form-control" id="opt4" name="opt4" required>
            </div>

            <div class="form-group">
                <input type="checkbox" name="check" id="ischecked" class="form-check-input">&nbsp;&nbsp;&nbsp;
                <label>التصحيح :</label>
                <input type="text" id="corr" class="form-control" name="corr" disabled>
            </div>
        </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
            <button type="submit" class="btn btn-primary">إضافة السؤال</button>
            </form>
        </div>
        </div>
    </div>
    </div>
    <!-- Edit Question Form Popup -->
    <div class="modal fade" id="editModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">تحديث سؤال</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" style="text-align:right;">
        <div id="edit-question-form" style="display: none;">
        <form id="edit-form">
            <div class="form-group">
                <label for="edit-ques">السؤال:</label>
                <input type="text" class="form-control" id="edit-ques" name="ques" required>
            </div>
            <lable>نوع السؤال :</label><br><br>
            <input type="radio" name="editType" value="trueOrFalse" class="trueOrFalse" id="editType" required>&nbsp;&nbsp;&nbsp;صح وغلط
            <br><br>
            <input type="radio" name="editType" value="choose" class="choose" id="editType" required>&nbsp;&nbsp;&nbsp;اختيار من متعدد 
            <br>
         <div id="editform2">
            <div class="form-group"><br>
                <input type="radio" name="editTru" value="true" class="editTrue" id="edit-tru" class="form-check-input" required>&nbsp;&nbsp;&nbsp;
                <label>صح</label>&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" name="editTru" value="false" class="editFalse" id="edit-false" class="form-check-input" required>&nbsp;&nbsp;&nbsp;
                <label>خطأ</label>
            </div>
         </div>
         <div id="editform1">
            <div class="form-group"><br>
                <input type="radio" name="ans" value="opt1" class="ans1" id="edit-ans" class="form-check-input" required>&nbsp;&nbsp;&nbsp;
                <label>الخيار 1:</label>
                <input type="text" class="form-control" id="edit-opt1" name="opt1" required>
            </div>

            <div class="form-group">
                <input type="radio" name="ans" value="opt2" class="ans2" id="edit-ans" class="form-check-input" required>&nbsp;&nbsp;&nbsp;
                <label>الخيار 2:</label>
                <input type="text" class="form-control" id="edit-opt2" name="opt2" required>
            </div>

            <div class="form-group">
                <input type="radio" name="ans" value="opt3" class="ans3" id="edit-ans" class="form-check-input" required>&nbsp;&nbsp;&nbsp;
                <label>الخيار 3:</label>
                <input type="text" class="form-control" id="edit-opt3" name="opt3" required>
            </div>

            <div class="form-group">
                <input type="radio" name="ans" value="opt4" class="ans4" id="edit-ans" class="form-check-input" required>&nbsp;&nbsp;&nbsp;
                <label>الخيار 4:</label>
                <input type="text" class="form-control" id="edit-opt4" name="opt4" required>
            </div>
            <input type="hidden" id="edit-question-id" name="id">
            <div class="form-group">
                <input type="checkbox" name="check" id="edit-ischecked" class="form-check-input">&nbsp;&nbsp;&nbsp;
                <label>التصحيح :</label>
                <input type="text" id="edit-corr" class="form-control" name="corr" disabled>
            </div>
     </div>
    </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
            <button type="submit" class="btn btn-primary">تحديث السؤال</button>
            </form>
        </div>
        </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        // Show add question form
        function showAddForm() {
            $('#add-question-form').show();
            $('#question-form').trigger("reset");
            $('#form1').hide();
            $('#form2').hide();
        }
        $('input[type=radio][name=editType]').change(function(){
            if(this.value == "choose"){
                $('#editform1').show();
                $('#editform2').hide();
            $('#edit-tru').prop('checked', false);
            $('#edit-false').prop('checked', false);
            $('#edit-question-form #edit-opt1').prop('disabled',false);
            $('#edit-question-form #edit-opt2').prop('disabled',false);
            $('#edit-question-form #edit-opt3').prop('disabled',false);
            $('#edit-question-form #edit-opt4').prop('disabled',false);
            $('#edit-question-form #edit-ans').prop('disabled',false);
            $("#edit-ischecked").prop('disabled', false);

            $('#edit-tru').prop('required', false);
            $('#edit-false').prop('required', false);
            $('#edit-question-form #edit-opt1').prop('required',true);
            $('#edit-question-form #edit-opt2').prop('required',true);
            $('#edit-question-form #edit-opt3').prop('required',true);
            $('#edit-question-form #edit-opt4').prop('required',true);
            $('#edit-question-form #edit-ans').prop('required',true);
            }else{
                $('#editform1').hide();
                $('#editform2').show();
            $('#edit-question-form #edit-opt1').val("");
            $('#edit-question-form #edit-opt2').val("");
            $('#edit-question-form #edit-opt3').val("");
            $('#edit-question-form #edit-opt4').val("");
            $('input[type=radio][name=ans]').prop('checked', false);
                    $("#edit-ischecked").prop('checked', false);
                    $("#edit-ischecked").prop('disabled', true);
            $('#edit-question-form #edit-opt1').prop('disabled',true);
            $('#edit-question-form #edit-opt2').prop('disabled',true);
            $('#edit-question-form #edit-opt3').prop('disabled',true);
            $('#edit-question-form #edit-opt4').prop('disabled',true);
            $('#edit-question-form #edit-ans').prop('disabled',true);
            $("#edit-corr").prop('disabled',true);
            $("#edit-corr").val("");

            
            $('#edit-tru').prop('required', true);
            $('#edit-false').prop('required', true);
            $('#edit-question-form #edit-opt1').prop('required',false);
            $('#edit-question-form #edit-opt2').prop('required',false);
            $('#edit-question-form #edit-opt3').prop('required',false);
            $('#edit-question-form #edit-opt4').prop('required',false);
            $('#edit-question-form #edit-ans').prop('required',false);
            }
        });

        $('input[type=radio][name=type]').change(function(){
            if(this.value == "choose"){
                $('#form1').show();
                $('#form2').hide();
            $('#tru').prop('checked', false);
            $('#false').prop('checked', false);
            $('#question-form #opt1').prop('disabled',false);
            $('#question-form #opt2').prop('disabled',false);
            $('#question-form #opt3').prop('disabled',false);
            $('#question-form #opt4').prop('disabled',false);
            $('#question-form #ans').prop('disabled',false);
            $("#ischecked").prop('disabled', false);

            $('#tru').prop('required', false);
            $('#false').prop('required', false);
            $('#question-form #opt1').prop('required',true);
            $('#question-form #opt2').prop('required',true);
            $('#question-form #opt3').prop('required',true);
            $('#question-form #opt4').prop('required',true);
            $('#question-form #ans').prop('required',true);

            }else{
                $('#form1').hide();
                $('#form2').show();
            $('#question-form #opt1').val("");
            $('#question-form #opt2').val("");
            $('#question-form #opt3').val("");
            $('#question-form #opt4').val("");
            $('input[type=radio][name=ans]').prop('checked', false);
                    $("#ischecked").prop('checked', false);
                    $("#ischecked").prop('disabled', true);
            $('#question-form #opt1').prop('disabled',true);
            $('#question-form #opt2').prop('disabled',true);
            $('#question-form #opt3').prop('disabled',true);
            $('#question-form #opt4').prop('disabled',true);
            $('#question-form #ans').prop('disabled',true);
            $("#corr").prop('disabled',true);
            $("#corr").val("");

            
            $('#tru').prop('required', true);
            $('#false').prop('required', true);
            $('#question-form #opt1').prop('required',false);
            $('#question-form #opt2').prop('required',false);
            $('#question-form #opt3').prop('required',false);
            $('#question-form #opt4').prop('required',false);
            $('#question-form #ans').prop('required',false);
            }
        });
        // Show edit question form
        function showEditForm(questionId, type, ques, opt1, opt2, opt3, opt4, ans, corr) {
            $('#edit-question-form #edit-question-id').val(questionId);
            $('#edit-question-form #edit-question-id').val(questionId);
            $('#edit-question-form #edit-ques').val(ques);
            switch(type){
                case "trueOrFalse":
                    $("#editform1").hide();
                    $("#editform2").show();
                    $(".trueOrFalse").prop('checked',true);
                    $('#edit-tru').prop('required', true);
                    $('#edit-false').prop('required', true);
                    $('#edit-question-form #edit-opt1').prop('required',false);
                    $('#edit-question-form #edit-opt2').prop('required',false);
                    $('#edit-question-form #edit-opt3').prop('required',false);
                    $('#edit-question-form #edit-opt4').prop('required',false);
                    $('#edit-question-form #edit-ans').prop('required',false);
                    $("#edit-ischecked").prop('required', false);
                    switch(ans){
                        case "true":
                            $('.editTrue').attr('checked', true);
                            break;
                        case "false":
                            $('.editFalse').attr('checked', true);
                            break;
                    }
                    break;
                case "choose":
                    $("#editform1").show();
                    $("#editform2").hide();
                    $('#edit-tru').prop('required', false);
                    $('#edit-false').prop('required', false);
                    $('#edit-question-form #edit-opt1').val(opt1);
                    $('#edit-question-form #edit-opt2').val(opt2);
                    $('#edit-question-form #edit-opt3').val(opt3);
                    $('#edit-question-form #edit-opt4').val(opt4);
                    $('#edit-question-form #edit-opt1').prop('required',true);
                    $('#edit-question-form #edit-opt2').prop('required',true);
                    $('#edit-question-form #edit-opt3').prop('required',true);
                    $('#edit-question-form #edit-opt4').prop('required',true);
                    $('#edit-question-form #edit-ans').prop('required',true);
                    $("#edit-ischecked").prop('required', true);
                    $(".choose").prop('checked',true);
                    break;
            }
            var cor = corr.replace('"',"");
            switch(cor){
                case "null":
                    $("#edit-ischecked").prop('checked', false);
                    $("#edit-corr").prop('required',false);
                    $("#edit-corr").prop('disabled',true);
                    break;
                default:
                    $("#edit-corr").prop('required',true);
                    $("#edit-corr").prop('disabled',false);
                    $("#edit-ischecked").prop('checked', true);
                    $('#edit-question-form #edit-corr').val(corr);
                    break;
            }

            switch (ans){
                case "opt1":
                    $('.ans1').attr('checked', true);
                    break;
                case "opt2":
                    $('.ans2').attr('checked', true);
                    break;
                case "opt3":
                    $('.ans3').attr('checked', true);
                    break;
                case "opt4":
                    $('.ans4').attr('checked', true);
                    break;
                    
            }
            $('#edit-question-form').show();
        }
        $("#edit-ischecked").change(function(){
            var editcheck = $('#edit-ischecked').is(":checked");
        if(editcheck == 1){
            $("#edit-corr").prop('required',true);
            $("#edit-corr").prop('disabled',false);
        }else{
            $("#edit-corr").prop('required',false);
            $("#edit-corr").prop('disabled',true);
            $("#edit-corr").val("");
        }
        });
        $("#ischecked").change(function(){
            var check = $('#ischecked').is(":checked");
            if (check == 1) {
                $("#corr").prop('required', true);
                $("#corr").prop('disabled', false);
            } else {
                $("#corr").prop('required', false);
                $("#corr").prop('disabled', true);
                $("#corr").val(""); // Clear the input value when disabled
            }
        });

        
        // Add new question using AJAX
        $('#question-form').on("submit",function(e){
            // Get form data
            e.preventDefault();
            var formData = $('#question-form').serialize();

            // AJAX request to add question
            $.ajax({
                type: 'POST',
                url: 'add_question.php', // Replace with the actual file handling AJAX requests
                data: formData,
                success: function(response) {
                    response = response.replace("</p>","");
                    var result = JSON.parse(response);
                    if (result.success) {
                        // Display success message
                        Swal.fire({
                            icon: 'success',
                            title: 'تمت إضافة السؤال بنجاح!',
                        }).then(function () {
                            // Reload the page to refresh the question list
                            location.reload();
                        });
                    } else {
                        // Display error message
                        Swal.fire({
                            icon: 'error',
                            title: 'حدث خطأ أثناء إضافة السؤال',
                        });
                    }
                },
                error: function() {
                    // Display error message
                    Swal.fire({
                        icon: 'error',
                        title: 'فشلت الطلب عبر AJAX',
                    });
                }
            });
        });

        // Update question using AJAX
        $('#edit-form').on("submit",function(e){
            e.preventDefault();
            // Get form data
            var formData = $('#edit-form').serialize();

            // AJAX request to update question
            $.ajax({
                type: 'POST',
                url: 'update_question.php', // Replace with the actual file handling AJAX requests
                data: formData,
                success: function(response) {
                    response = response.replace("</p>","");
                    var result = JSON.parse(response);
                    if (result.success) {
                        // Display success message
                        Swal.fire({
                            icon: 'success',
                            title: 'تم تحديث السؤال بنجاح!',
                        }).then(function () {
                            // Reload the page to refresh the question list
                            location.reload();
                        });
                    } else {
                        // Display error message
                        Swal.fire({
                            icon: 'error',
                            title: 'حدث خطأ أثناء تحديث السؤال',
                        });
                    }
                },
                error: function() {
                    // Display error message
                    Swal.fire({
                        icon: 'error',
                        title: 'فشلت الطلب عبر AJAX',
                    });
                }
            });
        });

        // Delete question using AJAX
        $(document).on('click', '.delete-btn', function() {
            var questionId = $(this).data('question-id');

            // AJAX request to delete question
            $.ajax({
                type: 'POST',
                url: 'delete_question.php', // Replace with the actual file handling AJAX requests
                data: { action: 'deleteQuestion', id: questionId },
                success: function(response) {
                    response = response.replace("</p>","");
                    var result = JSON.parse(response);
                    if (result.success) {
                        // Display success message
                        Swal.fire({
                            icon: 'success',
                            title: 'تم حذف السؤال بنجاح!',
                        }).then(function () {
                            // Reload the page to refresh the question list
                            location.reload();
                        });
                    } else {
                        // Display error message
                        Swal.fire({
                            icon: 'error',
                            title: 'حدث خطأ أثناء حذف السؤال',
                        });
                    }
                },
                error: function() {
                    // Display error message
                    Swal.fire({
                        icon: 'error',
                        title: 'فشلت الطلب عبر AJAX',
                    });
                }
            });
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php
}else{ header("Location: quiz-step-1");}} else {
    header("Location: /index");
}
?>