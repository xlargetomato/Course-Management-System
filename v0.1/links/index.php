<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="index.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="template.css" />
    <link rel="icon" href="/slider/book-_1_.ico">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;500;600;800;900;1000&display=swap" rel="stylesheet">
    <title>PotatosGroup</title>
    <link rel="icon" href="contents/2131.jpg">
  </head>
  <div class="navbares">
    <ul onclick="window.location = '/index';">
    <li><a>الصفحة الرئيسية</a></li>
</ul>
<img width="53px" src="/slider/LOGO.png" alt="" />
  </div>

          <div class="whatdoyouwant">
            <div class="kelos">
              <h1 onclick="window.location = 'subject/sub?code=<?=$_GET['code']?>'" class="titleone">المحاضرات</h1>
              <img src="محاضرات.jpg" alt="">
            </div>
            <!-- <div class="kelos">
              <h1 class="titleone">التكليفات</h1>
              <img src="./4.jpg" alt="">
            </div> -->
            <!-- <div class="kelos">
              <h1 class="titleone">كويزات</h1>
              <img src="4779390.webp" alt="">
            </div> -->
          </div>
      </div>
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
    <script src="index.js"></script>
  </body>
</html>