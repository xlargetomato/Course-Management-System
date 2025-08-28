<?php
error_reporting(E_ALL);
$done2 = 0;
$done = 0;
$db = '';
$host = '';
$user = '';
$pass = '';

define("db", $db);
define("host", $host);
define("pass", $pass);
define("user", $user);

// Connect to MySQL server
$MM = mysqli_connect($host, $user, $pass);
if (!$MM) {
    die('Could not connect: ' . mysqli_error($MM));
}

// Create the database if it doesn't exist
$db_selected = mysqli_select_db($MM, $db);
if (!$db_selected) {
    $sql = "CREATE DATABASE IF NOT EXISTS " . $db;
    if (mysqli_query($MM, $sql)) {
        echo "Database " . $db . " created successfully" . "<br/>";
        $done = 1;
    } else {
        echo 'Error creating database: ' . mysqli_error($MM) . "<br/>";
    }
}

// Select the database
mysqli_select_db($MM, $db);

// Check if the 'usr' table exists
$query = "SHOW TABLES LIKE 'usr'";
$result = mysqli_query($MM, $query);
if (mysqli_num_rows($result) == 0) {
    // 'usr' table doesn't exist, create it
    $query = "CREATE TABLE `usr` (
        `username` varchar(255) NOT NULL,
        `name` varchar(255) NOT NULL,
        `password` varchar(255) NOT NULL,
        `level` varchar(255) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
    if (mysqli_query($MM, $query)) {
        echo "Table 'usr' created successfully" . "<br/>";
    } else {
        echo 'Error creating table: ' . mysqli_error($MM) . "<br/>";
    }
}

$query = "SHOW TABLES LIKE 'media'";
$result = mysqli_query($MM, $query);
if (mysqli_num_rows($result) == 0) {
    // Create media table
    $query = "CREATE TABLE `media` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `title` VARCHAR(255) NOT NULL,
        `description` TEXT,
        `filename` VARCHAR(255) NOT NULL,
        `thumbnail` VARCHAR(255),
        `type` ENUM('image', 'video') NOT NULL,
        `subcode` VARCHAR(20) NOT NULL,
        `upload_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
    
    if (mysqli_query($MM, $query)) {
        echo "Table 'media' created successfully" . "<br/>";
    } else {
        echo 'Error creating media table: ' . mysqli_error($MM) . "<br/>";
    }
}


// Check if the 'course_schedule' table exists
$query = "SHOW TABLES LIKE 'course_schedule'";
$result = mysqli_query($MM, $query);
if (mysqli_num_rows($result) == 0) {
    // Create course_schedule table
    $query = "CREATE TABLE `course_schedule` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `day_of_week` VARCHAR(20) NOT NULL,
        `time_slot` VARCHAR(20) NOT NULL,
        `subject` VARCHAR(255) NOT NULL,
        `group_name` CHAR(1) NOT NULL,
        `room_number` VARCHAR(50),
        `instructor` VARCHAR(255),
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
    
    if (mysqli_query($MM, $query)) {
        echo "Table 'course_schedule' created successfully" . "<br/>";
        
        // Create indexes
        $index_queries = [
            "CREATE INDEX idx_schedule_group ON course_schedule(group_name)",
            "CREATE INDEX idx_schedule_day ON course_schedule(day_of_week)"
        ];
        
        foreach ($index_queries as $index_query) {
            if (mysqli_query($MM, $index_query)) {
                echo "Index created successfully" . "<br/>";
            } else {
                echo 'Error creating index: ' . mysqli_error($MM) . "<br/>";
            }
        }
    } else {
        echo 'Error creating course_schedule table: ' . mysqli_error($MM) . "<br/>";
    }
}

// Insert admin user if not already exists
$query = "SELECT * FROM `usr`";
$result = mysqli_query($MM, $query);
if (mysqli_num_rows($result) == 0) {
    $rand = rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
    $query = "INSERT INTO `usr`(`username`, `name`, `password`, `level`) VALUES ('admin','admin','$rand',4)";
    if (mysqli_query($MM, $query)) {
        echo "Admin user created successfully <br/>";
        echo "Username : admin <br/>";
        echo "Password : " . $rand . "<br/>";
    } else {
        echo 'Error creating Admin user: ' . mysqli_error($MM) . "<br/>";
        die();
    }
}

// Close the connection
mysqli_close($MM);

// Reconnect for the visitor tracking section
$MM = mysqli_connect($host, $user, $pass, $db);
mysqli_set_charset($MM, "utf8");

// Check connection
if ($MM->connect_error) {
    die();
}

// Get user's IP address
$user_ip = $_SERVER['REMOTE_ADDR'];

// Check if the user's IP exists in the database
$query = "SELECT * FROM visitors WHERE ip_address = '$user_ip'";
$result = $MM->query($query);

// If the IP address doesn't exist, insert it into the database and increase daily count
if ($result->num_rows == 0) {
  // Insert IP address into the database
  $insert_query = "INSERT INTO visitors (ip_address, visit_date) VALUES ('$user_ip', NOW())";
  if ($MM->query($insert_query)) {
    $VAR = mysqli_query($MM,'SET time_zone = "+02:00";');
    if($VAR){
    }else{
      die('error');
    }
      // Increase daily visit count
      $update_query = "UPDATE daily_visits SET visit_count = visit_count + 1 WHERE visit_date = CURDATE()";
      $pro = mysqli_query($MM, $update_query);
      if (!$pro || mysqli_affected_rows($MM) == 0) {
          // If no row is affected (no record for the current date), insert a new row
          $insert_daily_query = "INSERT INTO daily_visits (visit_date, visit_count) VALUES (CURDATE(), 1)";
          $MM->query($insert_daily_query);
      }

      // Check if the 'visited' cookie is not set (indicating a new visitor)
      if (!isset($_COOKIE['visited'])) {
          // Set the cookie
          setcookie('visited', 'true', time() + (10 * 365 * 24 * 60 * 60), '/');
          // Update the total visit count
          $update_total_query = "UPDATE total_visits SET visit_count = visit_count + 1";
          $proc = mysqli_query($MM, $update_total_query);
          if (!$proc || mysqli_affected_rows($MM) == 0) {
              // If no row is affected (no record for the total count), insert a new row
              $insert_total_query = "INSERT INTO total_visits (visit_count) VALUES (1)";
              $MM->query($insert_total_query);
          }
      }
  }
}
// Close connection
?>
