<?php
function enc($text, $key){
    if($text != "" && $key != ""){
        // Check if the link is already shortened
        global $MM;
        $stmt = $MM->prepare("SELECT id FROM link_mapping WHERE original_link = ?");
        $stmt->bind_param("s", $text);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            // If the link is already shortened, return the existing unique identifier
            return $row['id'];
        } else {
            // If the link is not already shortened, generate a new unique identifier
            $id = uniqid();
            // Store the mapping between the original link and its identifier in the database
            $stmt = $MM->prepare("INSERT INTO link_mapping (id, original_link) VALUES (?, ?)");
            $stmt->bind_param("ss", $id, $text);
            $stmt->execute();
            // Return the shortened link (the unique identifier)
            return $id;
        }
    }
    return "Error";
}


function dec($text, $key){
    if($text != "" && $key != ""){
        global $MM;
        // Retrieve the original link from the database using the unique identifier
        $stmt = $MM->prepare("SELECT original_link FROM link_mapping WHERE id = ?");
        $stmt->bind_param("s", $text);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            // Return the original link
            return $row['original_link'];
        } else {
            return "Link not found.";
        }
    } elseif($text == "") {
        return "text not provided.";
    } elseif($key == "") {
        return "key not provided.";
    } else {
        return "Error";
    }
}
?>