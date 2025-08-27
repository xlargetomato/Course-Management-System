<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="This is a website made for Matrouh Uni students to improve the accessibility to the courses content through the year.">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;500;600;800;900;1000&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="css/AllCss.css?a=s13" />
    <link rel="stylesheet" href="css/all.min.css" />
        <link rel="icon" href="content-and-imgs/fav.ico" type="image/icon type">
  </head>
  <body>
    <div class="main-flex page">
        <?php include('cpanel/sidebar.php');?>
          <div class="quest-long-idk">
            <img src="content-and-imgs/template.png" class="HUM" alt="" />
            <div class="where"><span class="text-where">> Home Page</span></div>
          </div>
          <div class="titleA-cont" style="
    position: absolute;
    transform: translate(-50%, -50%);
    top: 50%;
    left: 50%;
">
          <h1 class="titleA" style="
    text-align: center;
    font-size: 39px;
    position: absolute;
    transform: translate(-50%, -50%);
    top: 50%;
    left: 50%;
    width: 282px;
">Level - I</h1>
          </div>
        </div>
          <div>
            <svg
              class="waves"
              xmlns="http://www.w3.org/2000/svg"
              xmlns:xlink="http://www.w3.org/1999/xlink"
              viewBox="0 24 150 28"
              preserveAspectRatio="none"
              shape-rendering="auto"
            >
              <defs>
                <path
                  id="gentle-wave"
                  d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z"
                />
              </defs>
              <g class="parallax">
                <use
                  xlink:href="#gentle-wave"
                  x="48"
                  y="0"
                  fill="rgba(35,78,112,0.7)"
                />
                <use
                  xlink:href="#gentle-wave"
                  x="48"
                  y="3"
                  fill="rgba(35,78,112,0.5)"
                />
                <use
                  xlink:href="#gentle-wave"
                  x="48"
                  y="5"
                  fill="rgba(35,78,112,0.3)"
                />
                <use xlink:href="#gentle-wave" x="48" y="7" fill="#234E70" />
              </g>
            </svg>
        </div>
      </div>
    </div>
<?php include("cpanel/script.php"); ?>
  </body>
</html>
