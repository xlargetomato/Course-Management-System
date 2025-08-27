<?php
error_reporting(0);
session_start();
include("sql.php");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="CSS/all.min.css" />
    <!-- <link rel="stylesheet" href="CSS/all.min.css"> -->
    <link rel="stylesheet" href="CSS/template.css" />
    <link rel="stylesheet" href="CSS/normalize.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
    href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;500;600;800;900;1000&display=swap"
      rel="stylesheet"
      />
      
      <title>الصفحة الرئيسية</title>
      <link rel="icon" href="slider/book-_1_.ico" />
  </head>
  <body>
  <a id="buttonsq"></a>
    <div class="navbares">
      <!-- <div class="searchbar">
        <i class="fa-solid fa-magnifying-glass"></i>
      
        <input type="text" id="myInput"  placeholder="Search FoR Content"  >
      </div> -->
      <?php if($_SESSION['level'] == 1 OR $_SESSION['level'] == 2){?>
        <button id="show-element">مشرف</button>
        <?php }?>
        <?php if($_SESSION['level'] == 3){?>
        <button id="show-element">admin</button>
        <?php }?>
      <div class="containerupd">
        <!-- <div id="to-show" class="hide">
          <h4>الموقع لم ينتهي حد يضاف بعض التحديثات</h4>
          <br>
          <h4>تم اضافه الخ//</h4>
        </div> -->
      </div>
      
      <ul>
        <li><a href="#f">تكليفات</a></li>
        <li><a href="#c">المقررات</a></li>
        <li><a href="#">الصفحة الرئيسية</a></li>
      </ul>
      <img width="53px" src="slider/LOGO.png" alt="" />
      <!-- <div class="pswp__preloader__icn">
  <div class="pswp__preloader__cut">
    <div class="pswp__preloader__donut"></div>
  </div>
</div>
<h4>LOADING</h4> -->
    </div>
    <div id="box">
      <h1 class="title">قائمة الأختصارات</h1>
      <div id="items">
        <div class="item" id="Home">
          <i class="fa-solid fa-house"></i> الصفحه الرئيسية
        </div>
        <div class="item">
          <i class="fa-solid fs fa-book"></i> المقررات
          <?php $num = 0; foreach(mysqli_query($MM,"Select * FROM `subjects`") as $x){ $num++; ?>
          <div onclick="window.location = 'links/subject/sub?code=<?=$x['code']?>'; "class="item" id="CSD"><?=$x['name']?></div>
        <?php }if($num == 0){ ?>
            <h4>لم يتم إضافة مقررات حاليا</h4>
            <?php } ?>
        </div>
        <!-- <div class="item" id="tklf">
          <i class="fa-solid fs fa-book"></i> التكليفات الاسبوعيه
          <div class="item" id="CSDA">HTML</div>
          <div class="item" id="CSDA">CSS</div>
          <div class="item" id="CSDA">Javascript</div>
        </div> -->
        <!-- <div class="item" id="quizs">
          <i class="fa-regular fs fa-pen-to-square"></i> اختبارات بسيطه
          <div class="item" id="CSDB">Programming</div>
          <div class="item" id="CSDB">اختبار 2</div>
          <div class="item" id="CSDB">اختبار 3</div>
        </div> -->
        <!-- <div class="item" style="display: none;">
          <i class="fa-solid fs fa-bars"></i> About The Page
        </div> -->
        <div class="" style="padding: 5px;background-color: #171715;"><div style="padding-top:10px;text-align:center;font-wieght: bold;">قسم الإدارة</div>
        <?php if($_SESSION['level'] == 1 OR $_SESSION['level'] == 2 OR $_SESSION['level'] == 3){?>
          <div class="item" id="lect">
        <i color="#ffffff" class="fa-solid fs fa-gear"></i> إدارة المحاضرات
          <div class="item" onclick="window.location = 'cpanel/view-mat';" id="CSDX">عرض وإدارة المحاضرات</div>
          <div class="item" onclick="window.location = 'cpanel/mat';" id="CSDX">إضافة محاضرات</div>
          </div>
          <script>
            const lect = document.querySelector("#lect");
            const CSDX = document.querySelectorAll("#CSDX"); 
            lect.addEventListener("click", function () {
              for (var i = 0; i < CSDX.length; i++) {
                CSDX[i].classList.toggle("block");
              }
            });
          </script>
          <?php }?>
        <!-- <?php if($_SESSION['level'] == 1 OR $_SESSION['level'] == 2 OR $_SESSION['level'] == 3){?>
        <div class="item" onclick="window.location = 'cpanel/quiz';" id=""><i color="#ffffff" class="fa-solid fs fa-list"></i> إدارة الإختبارات
        </div>
          <?php }?> -->
        <?php if($_SESSION['level'] == 1 OR $_SESSION['level'] == 2 OR $_SESSION['level'] == 3){?>
        <div class="item" onclick="window.location = 'cpanel/assignment-manage';" id=""><i color="#ffffff" class="fa-solid fs fa-school"></i> إدارة التكاليف
        </div>
          <?php }?>
        <?php if($_SESSION['level'] == 3){?>
        <div class="item" onclick="window.location = 'cpanel/manage-users';" id=""><i color="#ffffff" class="fa-solid fs fa-user"></i> إدارة المستخدمين
        </div>
          <?php }?>
        <?php if($_SESSION['level'] == 3){?>
        <div class="item" onclick="window.location = 'cpanel/sub-manage';" id=""><i color="#ffffff" class="fa-solid fs fa-book"></i> إدارة المقررات
        </div>
          <?php }?>
        <?php if($_SESSION['level'] == 1 OR $_SESSION['level'] == 2 OR $_SESSION['level'] == 3){ }else{?>
        <div class="item" onclick="window.location = 'cpanel/login';" id=""><i color="#ffffff" class="fa-solid fs fa-sliders"></i> وحدة التحكم
        </div>
          <?php }?>
        <?php if($_SESSION['level'] == 1 OR $_SESSION['level'] == 2 OR $_SESSION['level'] == 3){?>
        <div class="item" onclick="window.location = 'cpanel/logout';" id=""><i color="#ffffff" class="fa-solid fs fa-right-from-bracket"></i> تسجيل الخروج
        </div>
          <?php }?>
          </div>
        <div class="item" id="themes"><i class="fa-solid fs fa-bars"></i> Themes
        <div class="item" id="CSDC">Defualt</div>
        <div class="item" id="CSDC">Dark/Black</div>
        <div class="item" id="CSDC">White/Light</div>
        </div>
      </div>
    </div>
    <div id="btn">
      <div id="top"></div>
      <div id="middle"></div>
      <div id="bottom"></div>
    </div>
    <div class="ground">
    <canvas id="canvas" class="canvas"></canvas>
      <div class="textsA">

        <h1>University Website</h1>
          <p>* أعتبر ده كلام جامد من الأخر لحد منلاقي حاجة نحطها مكانه *</p>
      </div>
      
      <div >
<svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
<defs>
<path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
</defs>
<g class="parallax">
<use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(35,78,112,0.7" />
<use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(35,78,112,0.5)" />
<use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(35,78,112,0.3)" />
<use xlink:href="#gentle-wave" x="48" y="7" fill="#234E70" />
</g>
</svg>
</div>
<!--Waves end-->

</div>
    </div>
    <div  class="secs" id="c">
      <h1>المقررات</h1>
      <span class="line"></span>
      <!-- <p>
        مساء الفل صباح الفل مساء الفل صباح الفل مساء الفل صباح الفل مساء الفل
        صباح الفل
      </p> -->
      <div class="gridsys">
        <?php $num = 0; foreach(mysqli_query($MM,"Select * FROM `subjects`") as $x){ $num++; ?>
          <div class="squ">
          <h4 onclick="window.location.href = 'links/subject/sub?code=<?=$x['code']?>';"><?=$x['name']?></h4>
          </div>
        <?php }if($num == 0){ ?>
          <div class="squ">
            <h4>لم يتم إضافة مقررات حاليا</h4>
          </div>
            <?php } ?>
        </div>
      </div>
    </div>
    <!-- <br />
    <div class="cnc">
      <h1 class="titles" id="f">التكليفات الأسبوعية</h1>
      <span class="linea"></span>
      <div class="cnsa">
        <div class="cns">
          <img src="slider/html2.png" alt="" />
          <h1 class="qu"></h1>
          <p>
          </p>
           <div class="button_container">
            <button>More</button>
          </div>
        </div>

      </div>
    </div>
    <div class="sectionusful">
      <h1>مقاطع فيديو</h1>
      <span class="line"></span>
      <h4>بعض المقاطع المفيده</h6>
      <div class="videos">
        <div class="video">
          <img src="slider/wallpaperflare.com_wallpaper (4).jpg" alt="" />
          <div class="texts">
            <a href=""><p>مقطع فيديو عن البوم البوم</p></a> 
          </div>
        </div>
        <div class="video">
          <img src="slider/wallpaperflare.com_wallpaper (4).jpg" alt="" />
          <div class="texts">
            <a href=""><p>مقطع فيديو عن البوم البوم</p></a> 
          </div>
        </div>
        <div class="video">
          <img src="slider/wallpaperflare.com_wallpaper (4).jpg" alt="" />
          <div class="texts">
            <a href=""><p>مقطع فيديو عن البوم البوم</p></a> 
          </div>        </div>
        <div class="video">
          <img src="slider/wallpaperflare.com_wallpaper (4).jpg" alt="" />
          <div class="texts">
            <a href=""><p>مقطع فيديو عن البوم البوم</p></a> 
          </div>        </div>
        <div class="video">
          <img src="slider/wallpaperflare.com_wallpaper (4).jpg" alt="" />
          <div class="texts">
            <a href=""><p>مقطع فيديو عن البوم البوم</p></a> 
          </div>        </div>
        <div class="video">
          <img src="slider/wallpaperflare.com_wallpaper (4).jpg" alt="" />
          <div class="texts">
            <a href=""><p>مقطع فيديو عن البوم البوم</p></a> 
          </div>        </div>
      </div>
    </div> -->
    <div class="sectionHow" id="f">
      <h1>التكليفات</h1>
      <span class="linea"></span>
      <div class="containerSection">
        <img class="secimg" src="slider/pngwing.com.png" alt="" />
        <div class="boxes">
          <?php $v = mysqli_query($MM,"SELECT * FROM weekly"); $num = 0; foreach($v as $x){$num++?>
          <div class="boxo">
            <img src="slider/to-do-list.png" alt="" />
            <div class="text">
              <h2><?=$x['subj']?></h2>
              <p>
                <?=$x['content']?>
                <div class="txx"><br> أخر معاد للتسليم : &nbsp; <?=$x['date-to']?></div>
              </p>
            </div>
          </div>
          <?php } if($num == 0){?>
          <div style="text-align:center;display:block" class="boxo">
            <div class="text">
              <h2>أبسط</h2>
              <p>
                مفيش تكاليف
              </p>
            </div>
          </div>
          <?php }?>
        </div>
      </div>
    </div>
    <footer class="footeres">
      <div class="container">
        <div class="row">
          <div class="footeres-col">
            <ul>
              <li><div><a><span style="font-size: 15px;">&copy; 2024</span>
                </a></div></li>
              </ul>
            </div>
            <div class="footeres-col">
              <!-- <ul>
                <li><a href="#">رأيك ؟</a></li>
              </ul> -->
            </div>
        </div>
      </div>
    </footer>
    <script src="dist/template.js"></script>
  </body>
</html>
