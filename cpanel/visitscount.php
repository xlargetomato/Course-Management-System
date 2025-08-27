<?php

// Check connection
if ($MM->connect_error) {
    die();
}

// Function to set a non-expiring cookie
function setCookieForever($name, $value) {
    setcookie($name, $value, time() + (10 * 365 * 24 * 60 * 60), '/');
}

// Check if the user has a cookie
if (!isset($_COOKIE['visited'])) {
    // Set a non-expiring cookie
    setCookieForever('visited', 'true');

    // Get user's IP address
    $user_ip = $_SERVER['REMOTE_ADDR'];

    // Check if the user's IP exists in the database
    $sql = "SELECT * FROM visitors WHERE ip_address = '$user_ip'";
    $result = $MM->query($sql);

    // If the IP address doesn't exist, insert it into the database and increase daily count
    if ($result->num_rows == 0) {
        // Insert IP address into the database
        $insert_sql = "INSERT INTO visitors (ip_address, visit_date) VALUES ('$user_ip', NOW())";
        $MM->query($insert_sql);

        // Increase daily visit count
        $update_sql = "UPDATE daily_visits SET visit_count = visit_count + 1 WHERE visit_date = CURDATE()";
        if ($MM->query($update_sql) === FALSE) {
            // If no row is affected (no record for the current date), insert a new row
            $insert_daily_sql = "INSERT INTO daily_visits (visit_date, visit_count) VALUES (CURDATE(), 1)";
            $MM->query($insert_daily_sql);
        }

        // Increase total visit count
        $update_total_sql = "UPDATE total_visits SET visit_count = visit_count + 1";
        if ($MM->query($update_total_sql) === FALSE) {
            // If no row is affected (no record for the total count), insert a new row
            $insert_total_sql = "INSERT INTO total_visits (visit_count) VALUES (1)";
            $MM->query($insert_total_sql);
        }
    }
}

// Close connection
$MM->close();
?>
