<?php
session_start();
include("sql.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SESSION["level"] != "" AND isset($_GET['name']) AND isset($_GET['subj'])) {
    // Retrieve subject and name from the query parameters
    $subj = isset($_GET['subj']) ? $_GET['subj'] : "";
    $name = isset($_GET['name']) ? $_GET['name'] : "";
    // Fetch questions based on subject and name
    $stmt = $MM->prepare("SELECT id, ques, opt1, opt2, opt3, opt4, ans, corr, type FROM quiz WHERE subj = ? AND name = ?");
    $stmt->bind_param("ss", $subj, $name);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if there are questions available
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <title>UniversityWebsite</title>

    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }

        .question-container {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .choices-container {
            margin-top: 10px;
        }
    </style>
    <?php
        if ($result->num_rows > 0) {

    ?>
</head>

<body>
    <div class="container"><br><br>
        <!-- <h2 style="text-align: center;">الاختبار</h2> -->
        <div id="quiz-container"></div><br><br>
        <div id="div-uwu">
        <div id="question-counter" style="text-align: center;"></div><br>
        <div style="text-align: center;">
            <button class="btn btn-primary" id="prevQuestionBtn">السؤال السابق</button>
            <button class="btn btn-primary" id="nextQuestionBtn">السؤال التالي</button>
        </div>
        </div>
    </div>
</body>
<script>
    $(document).ready(function () {
        var questions = <?php echo json_encode($result->fetch_all(MYSQLI_ASSOC)); ?>;
        var currentQuestionIndex = 0;
        var correctAnswersCount = 0;

        function displayQuestion() {
            var totalQuestions = questions.length;
            $('#question-counter').text("السؤال " + (currentQuestionIndex + 1) + " من " + totalQuestions);

            if (currentQuestionIndex < totalQuestions) {
                var currentQuestion = questions[currentQuestionIndex];
                var choicesHTML = '';
                if (currentQuestion['type'] === 'choose') {
                    choicesHTML = `
                        <div class="choices-container">
                            <label class="radio-inline"><input type="radio" name="answer" value="opt1">&nbsp;&nbsp;&nbsp; ${currentQuestion['opt1']}</label>
                            <label class="radio-inline"><input type="radio" name="answer" value="opt2">&nbsp;&nbsp;&nbsp; ${currentQuestion['opt2']}</label>
                            <label class="radio-inline"><input type="radio" name="answer" value="opt3">&nbsp;&nbsp;&nbsp; ${currentQuestion['opt3']}</label>
                            <label class="radio-inline"><input type="radio" name="answer" value="opt4">&nbsp;&nbsp;&nbsp; ${currentQuestion['opt4']}</label>
                        </div>
                    <br>`;
                } else if (currentQuestion['type'] === 'trueOrFalse') {
                    choicesHTML = `
                        <div class="choices-container">
                            <label class="radio-inline"><input type="radio" name="answer" value="true">&nbsp;&nbsp;&nbsp; صح</label>
                            <label class="radio-inline"><input type="radio" name="answer" value="false">&nbsp;&nbsp;&nbsp; خطأ</label>
                        </div>
                    <br>`;
                }

                var questionContainerHTML = `
                    <div class="question-container">
                        <p><strong>السؤال:</strong> ${currentQuestion['ques']}</p>
                        ${choicesHTML}
                        <button class="btn btn-primary" id="checkAnswerBtn">تحقق من الإجابة</button>
                    </div>
                `;

                $('#quiz-container').html(questionContainerHTML);

                // Attach click event to the dynamically created button
                $('#checkAnswerBtn').click(function () {
                    checkAnswer();
                });
            } else {
                // End of the quiz
                displayResults();
                $("#div-uwu").hide();

            }
        }

        function checkAnswer() {
            var selectedAnswer = $("input[name='answer']:checked").val();
            var currentQuestion = questions[currentQuestionIndex];
            var isCorrect = (selectedAnswer === currentQuestion['ans']);

            if (isCorrect) {
                correctAnswersCount++;
            }

            // Display feedback
            var feedbackMessage = isCorrect ? 'إجابة صحيحة' : 'إجابة خاطئة';
            Swal.fire({
                title: isCorrect ? 'إجابة صحيحة' : 'إجابة خاطئة',
                text: isCorrect ? '' : (currentQuestion['corr'] !== "null" ? 'التصحيح: ' + currentQuestion['corr'] : ''),
                icon: isCorrect ? 'success' : 'error',
                confirmButtonText: 'التالي',
            }).then((result) => {
                // Move to the next question
                currentQuestionIndex++;
                displayQuestion();
            });
        }

        function displayResults() {
            var totalQuestions = questions.length;
            var mark = (correctAnswersCount / totalQuestions) * 100;

            var resultsHTML = `
                <div class="results-container">
                    <h3>نتيجة الاختبار</h3>
                    <p>عدد الإجابات الصحيحة: ${correctAnswersCount}</p>
                    <p>إجمالي عدد الأسئلة: ${totalQuestions}</p>
                    <p>الدرجة: ${mark.toFixed(2)}%</p>
                </div>
            `;

            $('#quiz-container').html(resultsHTML);
        }

        // Initial display of the first question
        displayQuestion();

        // Attach click event to the next question button
        $('#nextQuestionBtn').click(function () {
            if (currentQuestionIndex < questions.length - 1) {
                currentQuestionIndex++;
                displayQuestion();
            }
        });

        // Attach click event to the previous question button
        $('#prevQuestionBtn').click(function () {
            if (currentQuestionIndex > 0) {
                currentQuestionIndex--;
                displayQuestion();
            }
        });
    });
</script>

</html>
<?php
    } else {
        // If there are no questions, display a SweetAlert and redirect to /index
        echo '<script>
                $(document).ready(function() {
                    Swal.fire({
                        title: "عذرا لا يوجد أسئلة لهذا الاختبار",
                        icon: "error",
                        showCancelButton: false,
                        showConfirmButton: false,
                        timer: 2000,
                    }).then(function() {
                        window.location.href = "/index";
                    });
                });
              </script>';
    }
} else {
    header("Location: /index");
}
?>
