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
    <link rel="stylesheet" href="css/all.min.css" />
</head>
<div class="main-flex page">
<?php 
include("sidebar.php");
session_start();
if(isset($_SESSION["level"]) AND $_SESSION["level"] == "4"){
?>
<div class="quest-long-idk">
            <img src="content-and-imgs/template.png" class="HUM" alt="" />
            <div class="where"><span class="text-where">> ControlPanel > History</span></div>
            </div>
            </div>
<br>
<center> <!-- لما center -->
<style>
  .x {
    width: 90%;
    display: flex;
    justify-content: space-between;
  }  @media (max-width: 768px) {
    .x {
      flex-direction: column;
      align-items: center;
    }
  }
  .z {
    margin-top: 20px;
  }
  .cCont{
  background-color: var(--hover1);
  display: flex;
  justify-content: left;
  margin-bottom: 20px;
  }
  .cCont > button {
  margin: 10px;
  text-align: center;
  }
</style>
    <!-- Filter by Username -->
    <div class="x">
    <div class="z">
    <label for="filter">Filter by Username :</label>
    <select class="form-control" style="height:50px;width:20%;min-width:300px;" id="filter">
      <option value="all">All</option>
      <!-- Options will be dynamically added here -->
    </select>
    </div>
    <!-- Filter by Date -->
    <div class="z">
    <label for="datePicker">Filter by Date :</label>
    <input type="date" class="form-control" style="height:50px;width:20%;min-width:300px;" id="datePicker" placeholder="Select date range">
    <br><br>
    </div>
    </div>
<div style="width: 90%;" class="cCont">
  <button class="btn" onclick="window.location = '/controlpanel';" style="color: var(--main2);background-color: var(--main1);"><i class="fa-solid fa-arrow-left"></i></button>
</div>
<table id="logTable" style="width: 90%;text-align:center;"class="table table-sm table-hover table-bordered">
  <thead>
    <tr>
      <th scope="col">اسم المستخدم</th>
      <th scope="col">الفعل</th>
      <th scope="col">الوقت والتاريخ</th>
    </tr>
  </thead>

  <tbody>
<?php $num = 0; $res = mysqli_query($MM,"SELECT * FROM `log` ORDER BY `time` DESC"); foreach($res as $e){$num++ ?>
    <tr>
      <td><?=$e['user']?></td>
      <td><?=$e['action']?></td>
      <td><?=$e['time']?></td>
    </tr>
<?php }if($num == 0){ ?>    
    <tr>
      <td colspan="3">لا يوجد نتائج</td>
    </tr>
    <?php } ?>
</body>
  </html><?php include("script.php"); ?>

  <script>
    window.onload = function() {
      populateFilterOptions();
      restrictDateSelection();
    };

    $('#filter, #datePicker').on("change", function() {
      applyFilter();
    });

    function populateFilterOptions() {
      var select = document.getElementById("filter");
      var table = document.getElementById("logTable");
      var usernames = [];
      for (var i = 1; i < table.rows.length; i++) {
        var username = table.rows[i].cells[0].innerText;
        if (!usernames.includes(username)) {
          usernames.push(username);
          var option = document.createElement("option");
          option.text = username;
          option.value = username;
          select.add(option);
        }
      }
    }

    function applyFilter() {
      var filterByUsername = document.getElementById("filter").value;
      var datePickerValue = document.getElementById("datePicker").value;
      var table = document.getElementById("logTable");
      var rows = table.getElementsByTagName("tr");
      for (var i = 1; i < rows.length; i++) {
        var cells = rows[i].getElementsByTagName("td");
        var username = cells[0].innerText;
        var date = cells[2].innerText.trim(); // Assuming the date is in the third column
        if ((filterByUsername == "all" || username == filterByUsername) &&
            (datePickerValue == "" || dateInRange(datePickerValue, date))) {
          rows[i].style.display = "";
        } else {
          rows[i].style.display = "none";
        }
      }
    }

    function dateInRange(datePickerValue, date) {
      // Parse and compare dates
      var selectedDate = new Date(datePickerValue);
      var logDate = new Date(date);
      return logDate.toDateString() === selectedDate.toDateString();
    }

    function restrictDateSelection() {
      var table = document.getElementById("logTable");
      var validDates = [];
      for (var i = 1; i < table.rows.length; i++) {
        var cells = table.rows[i].getElementsByTagName("td");
        var date = new Date(cells[2].innerText.trim()); // Assuming the date is in the third column
        var dateString = date.toISOString().split('T')[0];
        validDates.push(dateString);
      }
      // Disable dates that are not present in the table
      var datePicker = document.getElementById("datePicker");
      datePicker.setAttribute("min", validDates[validDates.length - 1]); // Minimum date is the latest date in the table
      datePicker.setAttribute("max", validDates[0]); // Maximum date is the earliest date in the table
      datePicker.addEventListener("input", function() {
        var selectedDate = this.value;
        if (!validDates.includes(selectedDate)) {
          this.value = "";
          alert("لا يوجد نتائج لهذا التاريخ .");
        }
      });
    }
  </script>


<?php }else{
      ?><script> window.location = "/controlpanel"; </script><?php
      } ?>
