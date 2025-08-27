<?php
include("sql.php"); 

$insertQuery = $MM->prepare("INSERT INTO usr (username, name, password, level) VALUES (?, ?, ?, ?)");
$username = "potato";
$name = "Potato User AAHAHA";
$password = "wanrltw"; // Consider hashing this before storing
$level = 4;

$insertQuery->bind_param("sssi", $username, $name, $password, $level);

if ($insertQuery->execute()) {
    echo "User 'potato' added successfully.";
} else {
    echo "Failed to add user: " . $MM->error;
}

$insertQuery->close();
$MM->close();
?>
