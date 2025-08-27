<?php
include('sql.php');
session_start();


// Get all schedule entries for a specific group
function getSchedule($group) {
    global $MM;
    $group = mysqli_real_escape_string($MM, $group);
    $query = "SELECT * FROM course_schedule WHERE group_name = '$group' ORDER BY 
        CASE 
            WHEN day_of_week = 'Saturday' THEN 1
            WHEN day_of_week = 'Sunday' THEN 2
            WHEN day_of_week = 'Monday' THEN 3
            WHEN day_of_week = 'Tuesday' THEN 4
            WHEN day_of_week = 'Wednesday' THEN 5
            WHEN day_of_week = 'Thursday' THEN 6
        END,
        time_slot";
    $result = mysqli_query($MM, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Add new schedule entry
function addScheduleEntry($data) {
    global $MM;
    
    $day = mysqli_real_escape_string($MM, $data['day']);
    $time = mysqli_real_escape_string($MM, $data['time']);
    $subject = mysqli_real_escape_string($MM, $data['subject']);
    $group = mysqli_real_escape_string($MM, $data['group']);
    $instructor = mysqli_real_escape_string($MM, $data['instructor']);
    
    $query = "INSERT INTO course_schedule (day_of_week, time_slot, subject, group_name, instructor) 
              VALUES ('$day', '$time', '$subject', '$group', '$instructor')";
    
    return mysqli_query($MM, $query);
}

// Update schedule entry
function updateScheduleEntry($id, $data) {
    global $MM;
    
    $id = mysqli_real_escape_string($MM, $id);
    $day = mysqli_real_escape_string($MM, $data['day']);
    $time = mysqli_real_escape_string($MM, $data['time']);
    $subject = mysqli_real_escape_string($MM, $data['subject']);
    $group = mysqli_real_escape_string($MM, $data['group']);
    $instructor = mysqli_real_escape_string($MM, $data['instructor']);
    
    $query = "UPDATE course_schedule 
              SET day_of_week = '$day',
                  time_slot = '$time',
                  subject = '$subject',
                  group_name = '$group',
                  instructor = '$instructor'
              WHERE id = '$id'";
    
    return mysqli_query($MM, $query);
}

// Delete schedule entry
function deleteScheduleEntry($id) {
    global $MM;
    $id = mysqli_real_escape_string($MM, $id);
    $query = "DELETE FROM course_schedule WHERE id = '$id'";
    return mysqli_query($MM, $query);
}

// Handle AJAX requests
if (isset($_POST['action'])) {
    
    header('Content-Type: application/json');
    $response = ['success' => false, 'message' => ''];
    
    switch ($_POST['action']) {
        case 'get':
            $group = $_POST['group'] ?? 'a';
            $response['data'] = getSchedule($group);
            $response['success'] = true;
            break;
            
        case 'add':
            if (addScheduleEntry($_POST)) {
                $response['success'] = true;
                $response['message'] = 'Schedule entry added successfully';
            } else {
                $response['message'] = 'Error adding schedule entry';
            }
            break;
            
        case 'update':
            if (updateScheduleEntry($_POST['id'], $_POST)) {
                $response['success'] = true;
                $response['message'] = 'Schedule entry updated successfully';
            } else {
                $response['message'] = 'Error updating schedule entry';
            }
            break;
            
        case 'delete':
            if (deleteScheduleEntry($_POST['id'])) {
                $response['success'] = true;
                $response['message'] = 'Schedule entry deleted successfully';
            } else {
                $response['message'] = 'Error deleting schedule entry';
            }
            break;
            case 'getSingle':
                $id = $_POST['id'] ?? 0;
                $query = "SELECT * FROM course_schedule WHERE id = '$id'";
                $result = mysqli_query($MM, $query);
                $response['data'] = mysqli_fetch_assoc($result);
                $response['success'] = true;
                break;
            
    }
    
    echo json_encode($response);
    exit();
}
?>