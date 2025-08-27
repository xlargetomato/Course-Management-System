<!DOCTYPE html>
  <head>
  <html lang="en" dir="ltr">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;500;600;800;900;1000&display=swap"
      rel="stylesheet"
    />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css?s=xds3ssssx">
    <link rel="stylesheet" href="css/AllCss.css?ad=zzzzzzz" />
    <link rel="stylesheet" href="css/all.min.css" />
  </head>
  <body>
    <script>
        var url = '<?php if($_GET['code'] != null){ echo '/lectureOrquestions?code=' . $_GET['code'];}else{echo '/index';} ?>';
    </script>
    <div class="main-flex page">
<?php
session_start();
include("cpanel/sidebar.php");
if (isset($_GET['name']) AND isset($_GET['subj'])) {
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
          <div class="quest-long-idk">
            <img src="content-and-imgs/template.png" class="HUM" alt="" />
            <div class="where"><span class="text-where">> اختبار</span></div>
          </div>
        </div>
    <?php
        if ($result->num_rows > 0) {

    ?>
</head>
<body>
<div class="container-quiz">
    <div class="quiz-card">
        <div class="progress-bar">
            <div class="progress-bar-fill" id="progressBar"></div>
        </div>
        <div id="quiz-container">
            <!-- Questions will be dynamically inserted here -->
        </div>
    </div>
    <div class="quiz-navigation">
            <!-- Question selection buttons will be dynamically inserted here -->
        </div>
    </div>

    <script>
     $(document).ready(function () {
    var questions = <?php echo json_encode($result->fetch_all(MYSQLI_ASSOC)); ?>;
    var currentQuestionIndex = 0;
    var correctAnswersCount = 0;
    var answeredQuestions = new Set(); // Track which questions have been answered
    var userAnswers = {}; // Store user's answers
    var correctQuestions = new Set(); // Track which questions were answered correctly

    function updateProgressBar() {
        const progress = ((currentQuestionIndex + 1) / questions.length) * 100;
        $('#progressBar').css('width', progress + '%');
    }

    function generateQuestionNavigation() {
        var navigationHTML = '';
        questions.forEach((_, index) => {
            let buttonClass = 'quiz-nav-btn';
            if (index === currentQuestionIndex) buttonClass += ' active';
            if (correctQuestions.has(index)) buttonClass += ' correct-answer';
            if (answeredQuestions.has(index) && !correctQuestions.has(index)) buttonClass += ' incorrect-answer';
            
            navigationHTML += `
                <button class="${buttonClass}" data-index="${index}">
                    ${index + 1}
                </button>`;
        });
        $('.quiz-navigation').html(navigationHTML);

        // Add click event for navigation buttons
        $('.quiz-nav-btn').click(function () {
            var targetIndex = $(this).data('index');
            currentQuestionIndex = targetIndex;
            displayQuestion();
        });
    }

    function displayQuestion() {
        var totalQuestions = questions.length;
        updateProgressBar();
        generateQuestionNavigation();

        if (currentQuestionIndex < totalQuestions) {
            var currentQuestion = questions[currentQuestionIndex];
            var choicesHTML = '';
            var isAnswered = answeredQuestions.has(currentQuestionIndex);
            var userAnswer = userAnswers[currentQuestionIndex];

            if (currentQuestion['type'] === 'choose') {
                choicesHTML = `
                    <div class="choices-container">
                        ${['opt1', 'opt2', 'opt3', 'opt4'].map(opt => `
                            <label class="radio-inline ${isAnswered ? 'disabled' : ''}">
                                <input type="radio" name="answer" value="${opt}"
                                    ${isAnswered ? 'disabled' : ''}
                                    ${userAnswer === opt ? 'checked' : ''}>
                                <div>${currentQuestion[opt]}</div>
                            </label>
                        `).join('')}
                    </div>`;
            } else if (currentQuestion['type'] === 'trueOrFalse') {
                choicesHTML = `
                    <div class="choices-container">
                        ${['true', 'false'].map(value => `
                            <label class="radio-inline ${isAnswered ? 'disabled' : ''}">
                                <input type="radio" name="answer" value="${value}"
                                    ${isAnswered ? 'disabled' : ''}
                                    ${userAnswer === value ? 'checked' : ''}>
                                <div>${value === 'true' ? 'صح' : 'خطأ'}</div>
                            </label>
                        `).join('')}
                    </div>`;
            }

            var questionHTML = `
                <div class="question-container">
                    <div class="question-header">
                        <span class="question-counter">السؤال ${currentQuestionIndex + 1} من ${totalQuestions}</span>
                    </div>
                    <p class="question-text">${currentQuestion['ques']}</p>
                    ${choicesHTML}
                    <div class="button-container">
                        <button class="btn btn-secondary" id="prevQuestionBtn" ${currentQuestionIndex === 0 ? 'style="visibility: hidden"' : ''}>السابق</button>
                        ${!isAnswered ? `<button class="btn btn-primary" id="checkAnswerBtn">تحقق من الإجابة</button>` : ''}
                    </div>
                </div>`;

            $('#quiz-container').html(questionHTML);

            if (!isAnswered) {
                $('#checkAnswerBtn').click(function () {
                    checkAnswer();
                });
            }

            $('#prevQuestionBtn').click(function () {
                if (currentQuestionIndex > 0) {
                    currentQuestionIndex--;
                    displayQuestion();
                }
            });
        } else {
            displayResults();
        }
    }

    function checkAnswer() {
        var selectedInput = $("input[name='answer']:checked");
        if (!selectedInput.length) {
            Swal.fire({
                title: 'تنبيه',
                text: 'الرجاء اختيار إجابة',
                icon: 'warning',
                confirmButtonText: 'حسناً'
            });
            return;
        }

        var selectedAnswer = selectedInput.val();
        var currentQuestion = questions[currentQuestionIndex];
        var isCorrect = (selectedAnswer === currentQuestion['ans']);

        // Store user's answer
        userAnswers[currentQuestionIndex] = selectedAnswer;
        answeredQuestions.add(currentQuestionIndex);
        
        if (isCorrect) {
            correctAnswersCount++;
            correctQuestions.add(currentQuestionIndex);
        }

        Swal.fire({
            title: isCorrect ? 'إجابة صحيحة' : 'إجابة خاطئة',
            html: isCorrect ? '' : (currentQuestion['corr'] !== "null" ? 'التصحيح: ' + currentQuestion['corr'] : ''),
            icon: isCorrect ? 'success' : 'error',
            confirmButtonText: 'التالي',
            confirmButtonColor: '#2563eb'
        }).then(() => {
            currentQuestionIndex++;
            displayQuestion();
        });
    }

    function displayResults() {
        var totalQuestions = questions.length;
        var score = (correctAnswersCount / totalQuestions) * 100;

        var resultsHTML = `
            <div class="question-container">
                <div class="results-container">
                    <h3>نتيجة الاختبار</h3>
                    <div class="results-score">${score.toFixed(1)}%</div>
                    <p>عدد الإجابات الصحيحة: ${correctAnswersCount}</p>
                    <p>إجمالي عدد الأسئلة: ${totalQuestions}</p>
                    <button class="btn btn-primary" onclick="window.location = url">الرجوع</button>
                </div>
            </div>`;

        $('#quiz-container').html(resultsHTML);
    }

    // Start the quiz
    displayQuestion();
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
} else { ?>
    <script>window.location = '/index';</script>
<?php }
?>
<?php include("cpanel/script.php"); ?>
