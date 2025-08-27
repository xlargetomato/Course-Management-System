<?php
// Include the database connection or initialization file
include("cpanel/sql.php");

// Check if the 'id' parameter is present in the URL
if(isset($_GET['id'])) {
    // Get the ID from the query parameters
    $id = $_GET['id'];
    
    // Prepare and execute a SELECT query to retrieve the original link from the database using the ID
    $stmt = $MM->prepare("SELECT original_link FROM link_mapping WHERE id = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Check if a row is fetched
    if($row = $result->fetch_assoc()) {
        // Extract the original link from the database
        $original_link = $row['original_link'];
        
        // Explode the original link by '-' to get the quiz name and subject
        $parts = explode("-", $original_link);
        
        // Check if both parts are present
        if(count($parts) == 2) {
            // Redirect the user to the quiz page with the specified name and subject
            $name = $parts[1];
            $subj = $parts[0];
            header("Location: quiz-user.php?name=$name&subj=$subj");
            exit; // Stop further execution
        } else {
            // If the original link does not contain both name and subject, display an error message
            echo "حدث خطأ 1002";
        }
    } else {
        // If the ID is not found in the database, display an error message
        echo "حدث خطأ 1004";
    }
} else {
    // If the 'id' parameter is not present in the URL, display an error message
    ?><script>window.location = '/';</script><?php
}
?>
