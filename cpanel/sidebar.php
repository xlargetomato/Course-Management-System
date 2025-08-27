<?php
include('sql.php');
session_start();
$curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
$curDirName = explode("/",$_SERVER['REQUEST_URI']);
?>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<title>Level-I</title>

<link rel="icon" href="content-and-imgs/learning_4185714.ico" />
<style>
/* Popup Trigger Button */
.popup-trigger {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 0.75rem;
  cursor: pointer;
  background-color: var(--main2);
  color: white;
  border-radius: 0.5rem;
  transition: background-color 0.2s;
}

.popup-trigger:hover {
  background-color: var(--hover1);
}

.popup-trigger i {
  font-size: 1.25rem;
}

.popup-trigger span {
  font-size: 1rem;
}

/* Popup Overlay */
.popup-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 100;
}

/* Popup Container */
.popup {
  background-color: white;
  border-radius: 0.5rem;
  max-width: 1200px;
  max-height: 90vh;
  /* overflow: auto; */
  position: relative;
}



/* Popup Controls */
.popup-controls button {
  background-color: transparent;
  border: none;
  cursor: pointer;
  padding: 0.5rem;
  border-radius: 0.25rem;
  transition: background-color 0.2s;
}

.popup-controls button:hover {
  background-color: var(--main3);
}

.popup-controls {
  display: flex
;
    justify-content: space-between;
  align-items: center;
  padding: 1rem;
  border-bottom: 1px solid var(--main3);
  background-color: var(--main2);  position: sticky;
  top: 64px;
  z-index: 2;
}



@media (max-width: 768px) {
  .popup {
    width: 100%;
    max-height: 100vh;
    border-radius: 0;
    margin: 0;
  }

.sidebar {
  width: max-content;
}

.move-right {
      margin-left: 208px;
}

}

/* Extra Small Screens */




/* ////////////// */

.modal {
  display: none;
  position: fixed;
  z-index: 1000;
  padding-top: 60px;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.8);
}

.modal-content {
  margin: auto;
  display: block;
  max-width: 700px;
}

.close {
  position: absolute;
  top: 20px;
  right: 35px;
  color: white;
  font-size: 40px;
  font-weight: bold;
  cursor: pointer;
}

</style>
<div class="sidebar">
        <p class="sidebar-title">Level-I</p>
        <div class="linkdad">
          <div class="link <?php
              if($curPageName == "index.php"){ echo "selected";}
              ?>">
            <i class="fa-solid fa-house ani-hover"></i> <span>Home Page</span>
          </div>
          <div class="link <?php
              if($curPageName == "course.php"){ echo "selected";}
              ?>">
            <i class="fa-solid fa-book ani-hover"></i>
            <span>Courses</span>
          </div>
          <div class="link toggle <?php  
              if($curPageName == "lectureOrquestions.php"){ echo "selected";}
              ?>">
            <i class="fa-solid fa-book ani-hover"></i>
            <span>Lectures\Questions</span>
          </div>
          <ul class="listA">
            <?php
            $q = mysqli_query($MM,"SELECT * FROM `subjects`");
            foreach($q as $row){
              ?>
            <li onclick="window.location = '/lectureOrquestions?code=<?=$row['code']?>';"><?=$row['name']?></li>
            <?php
            }
            ?>
          </ul>
          <div class="link <?php
              if($curPageName == "assignments.php"){ echo "selected";}
              ?>">
            <i class="fa-solid fa-list-check ani-hover"></i>
            <span>Assignments</span>
          </div>
          <div class="link <?php
              if($curPageName == "finalprojects.php"){ echo "selected";}
              ?>">
            <i class="fa-solid fa-list ani-hover"></i>
            <span>Final Projects</span>
          </div>
          <div class="link <?php  
              if($curPageName == "controlpanel.php"){ echo "selected";}
              if($curDirName[1] == "cpanel"){ echo "selected";}
              ?>">
            <i class="fa-solid fa-gears ani-hover"></i>
            <span>Control Panel</span>
          </div>
          <!-- <div class="link" id="schedule-link">
            <i class="fa-solid fa-table ani-hover"></i>
            <span>Schedule</span>
          </div> -->
          <!-- 
          <ul class="listB">
          <li class="themeChange-DARK">Dark</li>
          <li class="themeChange-MAIN">MAIN</li>
        </ul> -->
          <!-- <div class="link   
          <?php // if($curPageName == "about.php"){ echo "selected";} ?>
              ">
            <i class="fa-regular fa-circle-question ani-hover"></i>
            <span>About</span>
          </div> -->
        </div>
        <!-- <div class="popup-trigger">
    <i class="fa-solid fa-calendar-days"></i>
    <span>Course Schedule</span>
  </div> -->
                <div style='    font-size: 12px;
    text-align: center;
'>Made with ❤️ by تربية نوعية</div>
      </div>
<style>


.schedule-image {
    display: none;
    max-width: 100%;
    height: auto;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}
 :root {
            --main-color: #3498db;
            --main-color-light: #5faee3;
            --text-color: #333;
            --border-color: #d1d8e0;
            --bg-color: #f9fafb;
        }

        .custom-select {
            position: relative;
            display: inline-block;
            width: 200px;
        }

        .custom-select__select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            width: 100%;
            padding: 0.75rem 2.5rem 0.75rem 1rem;
            font-size: 1rem;
            color: var(--text-color);
            background-color: var(--bg-color);
            border: 2px solid var(--border-color);
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .custom-select__select:hover {
            border-color: var(--main-color);
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.1);
        }

        .custom-select__select:focus {
            outline: none;
            border-color: var(--main-color);
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
        }

        .custom-select__icon {
            position: absolute;
            top: 50%;
            right: 1rem;
            transform: translateY(-50%);
            pointer-events: none;
            color: var(--main-color);
        }

        .custom-select__icon svg {
            width: 1.2rem;
            height: 1.2rem;
        }
</style>
<div class="popup-overlay" style="display:none;">
    <div class="popup">
        <div class="popup-controls">
 <div class="custom-select">
        <select id="group-select" class="custom-select__select">
            <option value="a">Group A</option>
            <option value="b">Group B</option>
        </select>
        <div class="custom-select__icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m6 9 6 6 6-6"/>
            </svg>
        </div>
    </div>
            <button class="close-popup">
                <i class="fa-solid fa-xmark"></i>

            </button>
        </div>
        

        <img id="group-a-schedule" class="schedule-image" src="content-and-imgs/group-a-schedule.jpg" alt="Group A Schedule">
        <img id="group-b-schedule" class="schedule-image" src="content-and-imgs/group-b-schedule.jpg" alt="Group B Schedule">
    </div>
</div>
<div id="photoModal" class="modal">
  <span class="close">&times;</span>
  <img class="modal-content" id="modalImage">
</div>
      <div class="contentA">
        <div class="TOP">
          <div class="navbar-no-boots">
            <img src="content-and-imgs/LOGO.png" width="31" height="32" alt="" />
            <div class="content-navbar">
                <?php 
                switch($_SESSION['level']){
                    case "1":?>
                      <div class="role" style='color: green;font-weight: bold;'>Mod</div>
                      <?php
                      break;
                    case "2";
                      ?>
                      <div class="role" style='color: red; font-weight: bold;'>Admin</div>
                      <?php
                    break;
                    case "3":
                      ?>
                      <div style="color: DarkRed;font-weight: bold;" class="role">Head Admin</div>
                      <?php
                    break;
                    case "4":
                      ?>
                      <div style="color: GoldenRod;font-weight: bold;" class="role">Owner</div>
                      <?php
                    break;
                    
                }
                if(isset($_SESSION['level'])){
                  ?><p style="margin-bottom:0;">
                  <a onclick="window.location = '/cpanel/logout';" class="" style="color: #ffffff;"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
                </p>
                  <?php
                }
                ?>
            </div>
          </div>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const scheduleLink = document.getElementById('schedule-link');
    const popupOverlay = document.querySelector('.popup-overlay');
    const groupButtons = document.querySelectorAll('.group-btn');
    const scheduleImages = document.querySelectorAll('.schedule-image');
    const closeButton = document.querySelector('.close-popup');
    const groupSelect = document.getElementById('group-select');

    scheduleLink.addEventListener('click', () => {
        popupOverlay.style.display = 'flex';
        document.getElementById('group-a-schedule').style.display = 'block';
        document.querySelector('.group-btn[data-group="a"]').style.backgroundColor = 'var(--hover1)';
        groupSelect.value = 'a';
    });


    groupSelect.addEventListener('change', () => {
        const group = groupSelect.value;
        scheduleImages.forEach(img => {
            img.style.display = img.id === `group-${group}-schedule` ? 'block' : 'none';
        });

        groupButtons.forEach(btn => {
            btn.style.backgroundColor = btn.dataset.group === group ? 'var(--hover1)' : 'var(--main2)';
        });
    });

    closeButton.addEventListener('click', () => {
        popupOverlay.style.display = 'none';
    });

    popupOverlay.addEventListener('click', (e) => {
        if (e.target === popupOverlay) {
            popupOverlay.style.display = 'none';
        }
    });
});
</script>