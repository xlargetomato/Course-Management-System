<!DOCTYPE html>
<html lang="ar" dir="rtl">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;500;600;800;900;1000&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="css/AllCss.css" />
    <link rel="stylesheet" href="css/all.min.css" />
    <style>
      :root {
        --primary: #1e3a5f;
        --primary-light: #2c5282;
        --secondary: #f9e79f;
        --background: #f7f9fc;
        --text-dark: #2d3748;
        --text-light: #e2e8f0;
        --accent: #2c7a7b;
        --hover: #3182ce;
        --border-radius: 12px;
        --box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        --transition: all 0.3s ease;
      }
      
      body {
        font-family: 'Cairo', sans-serif;
        margin: 0;
        padding: 0;
      }
      
      .assignments-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
      }
      
      .page-title {
        color: var(--text-dark);
        text-align: center;
        margin-bottom: 30px;
        font-size: 2.5rem;
        font-weight: 800;
        position: relative;
        padding-bottom: 15px;
      }
      
      .page-title:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 150px;
        height: 4px;
        background: linear-gradient(to right, var(--primary), var(--accent));
        border-radius: 2px;
      }
      
      /* Week selector dropdown styling */
      .week-selector {
        position: relative;
        width: 100%;
        max-width: 400px;
        margin: 0 auto 40px;
      }
      
      .week-dropdown-button {
        background-color: var(--primary);
        color: white;
        padding: 12px 20px;
        border-radius: var(--border-radius);
        width: 100%;
        text-align: center;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: var(--box-shadow);
      }
      
      .week-dropdown-content {
        display: none;
        position: absolute;
        background-color: white;
        width: 100%;
        border-radius: var(--border-radius);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        z-index: 1;
        max-height: 300px;
        overflow-y: auto;
      }
      
      .week-dropdown-content.show {
        display: block;
      }
      
      .week-option {
        padding: 12px 16px;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        justify-content: space-between;
        align-items: center;
      }
      
      .week-option:hover {
        background-color: var(--background);
      }
      
      .week-option.active {
        background-color: var(--primary-light);
        color: white;
      }
      
      .assignments-count {
        background-color: var(--secondary);
        color: var(--primary);
        border-radius: 50px;
        padding: 2px 10px;
        font-weight: 600;
        font-size: 0.9rem;
      }
      
      .assignments-list {
        display: none;
        padding: 20px;
        margin-bottom: 40px;
      }
      
      .assignments-list.active {
        display: block;
        animation: fadeIn 0.5s ease;
      }
      
      .week-title {
        color: var(--primary);
        font-size: 1.5rem;
        margin-bottom: 20px;
        font-weight: 700;
        padding-bottom: 10px;
        border-bottom: 2px solid var(--primary-light);
      }
      
      .assignment-item {
        margin-bottom: 20px;
        border-radius: var(--border-radius);
        background-color: var(--background);
        overflow: hidden;
        transition: var(--transition);
      }
      
      .assignment-item:last-child {
        margin-bottom: 0;
      }
      
      .assignment-header {
        padding: 15px 20px;
        background-color: var(--primary-light);
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
      }
      
      .assignment-title {
        font-weight: 600;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
      }
      
      .assignment-type {
        background-color: white;
        color: var(--primary);
        border-radius: 50px;
        padding: 3px 12px;
        font-size: 0.8rem;
        margin-left: 10px;
      }
      
      .assignment-type.practical {
        background-color: var(--accent);
        color: white;
      }
      
      .assignment-content {
        padding: 20px;
        display: none;
      }
      
      .assignment-description {
        margin-bottom: 15px;
        line-height: 1.6;
      }
      
      .assignment-deadline {
        color: var(--primary);
        font-weight: 600;
        font-size: 0.9rem;
      }
      
      .chevron-icon {
        transition: transform 0.3s ease;
      }
      
      .assignment-item.open .chevron-icon {
        transform: rotate(180deg);
      }
      
      @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
      }
    </style>
  </head>
  <body >
    <div class="main-flex page " dir="ltr">
      <?php include("cpanel/sidebar.php"); ?>
      <div class="quest-long-idk">
        <img src="content-and-imgs/template.png" class="HUM" alt="" />
        <div class="where"><span class="text-where">> Assignments</span></div>
      </div>
    </div>
    
    <div class="assignments-container">
      <h1 class="page-title">التكليفات</h1>
      
      <?php
      $res = mysqli_query($MM, "SELECT * FROM weekly");
      if($res->num_rows > 0) {
        // Define all weeks
        $weeks = [
          'الأول', 'الثاني', 'الثالث', 'الرابع', 'الخامس', 'السادس',
          'السابع', 'الثامن', 'التاسع', 'العاشر', 'الحادي عشر', 'الثاني عشر'
        ];
        
        // Group assignments by week
        $assignmentsByWeek = [];
        foreach ($weeks as $week) {
          $assignmentsByWeek[$week] = [];
        }
        
        // Populate assignments by week
        foreach ($res as $row) {
          $week = isset($row['week']) ? $row['week'] : 'الأول'; // Default to first week if not set
          $assignmentsByWeek[$week][] = $row;
        }
        
        // Create dropdown for weeks
        ?>
        <div class="week-selector" dir="rtl">
          <div class="week-dropdown-button">
            <span>الأسبوع الأول</span>
            <i class="fa-solid fa-chevron-down"></i>
          </div>
          <div class="week-dropdown-content">
            <?php
            foreach ($weeks as $week) {
              $count = count($assignmentsByWeek[$week]);
              $activeClass = $week === 'الأول' ? 'active' : '';
              
              echo '<div class="week-option ' . $activeClass . '" data-week="' . $week . '">';
              echo '<span>الأسبوع ' . $week . '</span>';
              echo '<span class="assignments-count">' . $count . ' تكليف</span>';
              echo '</div>';
            }
            ?>
          </div>
        </div>
        
        <?php
        // Display assignments for each week
        foreach ($weeks as $week) {
          $activeClass = $week === 'الأول' ? 'active' : '';
          echo '<div dir="rtl" id="week-' . $week . '-assignments" class="assignments-list ' . $activeClass . '">';
          echo '<h2 class="week-title">تكليفات الأسبوع ' . $week . '</h2>';
          
          if (count($assignmentsByWeek[$week]) > 0) {
            foreach ($assignmentsByWeek[$week] as $row) {
              $typeClass = $row['type'] == 0 ? '' : 'practical';
              $typeText = $row['type'] == 0 ? 'نظري' : 'عملي';
              ?>
              <div class="assignment-item">
                <div class="assignment-header">
                  <div class="assignment-title">
                    <span class="assignment-type <?php echo $typeClass; ?>"><?php echo $typeText; ?></span>
                    <?php echo $row['subj']; ?>
                  </div>
                  <i class="fa-solid fa-chevron-down chevron-icon"></i>
                </div>
                <div class="assignment-content">
                  <div class="assignment-description">
                    <?php echo nl2br(stripcslashes($row['content'])); ?>
                  </div>
                </div>
              </div>
              <?php
            }
          } else {
            echo '<div class="no-assignments">لا يوجد تكليفات لهذا الأسبوع</div>';
          }
          
          echo '</div>';
        }
      } else {
        ?>
        <div class="assign-container">
          <div class="text-assign"><div style="text-align:center;"class="">لا يوجد تكليفات حاليا</div></div>
        </div>
        <?php
      }
      ?>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
      $(document).ready(function(){
        // Hide all assignment content initially
        $(".assignment-content").hide();
        
        // Toggle assignment content when clicking on header
        $(".assignment-header").click(function(){
          const item = $(this).parent();
          item.toggleClass("open");
          $(this).next(".assignment-content").slideToggle(300);
        });
        
        // Toggle dropdown menu
        $(".week-dropdown-button").click(function(){
          $(".week-dropdown-content").toggleClass("show");
        });
        
        // Close dropdown when clicking outside
        $(document).click(function(e) {
          if (!$(e.target).closest('.week-selector').length) {
            $(".week-dropdown-content").removeClass("show");
          }
        });
        
        // Show assignments for week when clicking on week option
        $(".week-option").click(function(){
          const week = $(this).data("week");
          const weekText = "الأسبوع " + week;
          
          // Toggle active class on week option
          $(".week-option").removeClass("active");
          $(this).addClass("active");
          
          // Update dropdown button text
          $(".week-dropdown-button span").text(weekText);
          
          // Hide dropdown
          $(".week-dropdown-content").removeClass("show");
          
          // Hide all week assignments and show the clicked one
          $(".assignments-list").removeClass("active");
          $("#week-" + week + "-assignments").addClass("active");
        });
      });
    </script>
    <?php include("cpanel/script.php"); ?>
  </body>
</html>