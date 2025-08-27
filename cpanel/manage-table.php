<?php
include('schedule-controller.php');
?>
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
    <link rel="stylesheet" href="manage-users.css" />
    <link rel="stylesheet" href="css/all.min.css" />
</head>
<div class="main-flex page">
<?php
include("sidebar.php");
session_start();
if ($_SESSION["level"] >= "3") {
    ?>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            color: #f0f0f7;
        }

        h3 {
            color: #fbf8be;
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
            border-bottom: 3px solid #234e70;
            padding-bottom: 0.5rem;
            display: inline-block;
        }

        .container {
            max-width: 1000px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: #234e70;
            border-radius: 1.5rem;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #fbf8be;
            font-size: 0.95rem;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #19384f;
            border-radius: 0.75rem;
            background-color: #19384f;
            color: #f0f0f7;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #fbf8be;
            box-shadow: 0 0 0 3px rgba(251, 248, 190, 0.1);
        }

        .form-group input::placeholder {
            color: #f0f0f7;
            opacity: 0.6;
        }

        .btn-group {
            text-align: right;
            margin-top: 2rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 0.75rem;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
            font-family: 'Poppins', sans-serif;
        }

        .btn-primary {
            background-color: #fbf8be;
            color: #19384f;
        }

        .btn-primary:hover {
            background-color: #fff;
            transform: translateY(-2px);
        }

        .btn-danger {
            background-color: #ff6b6b;
            color: #fff;
            margin-left: 1rem;
        }

        .btn-danger:hover {
            background-color: #ff5252;
            transform: translateY(-2px);
        }

        .schedule-table {
            margin-top: 3rem;
            background-color: #234e70;
            border-radius: 1rem;
            overflow: hidden;
        }

        .schedule-entry {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.25rem;
            margin-bottom: 1rem;
            background-color: #19384f;
            border-left: 4px solid #fbf8be;
            border-radius: 0.75rem;
            transition: all 0.3s ease;
        }

        .schedule-entry:hover {
            transform: translateX(5px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            background-color: #1a4057;
        }

        .schedule-entry .details {
            flex-grow: 1;
            color: #f0f0f7;
        }

        .schedule-entry .details strong {
            color: #fbf8be;
            font-weight: 600;
        }

        .schedule-entry .actions {
            display: flex;
            gap: 0.75rem;
        }

        .schedule-entry .actions .btn {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }

        .schedule-entry .actions .btn-primary {
            background-color: #234e70;
            color: #fbf8be;
            border: 1px solid #fbf8be;
        }

        .schedule-entry .actions .btn-primary:hover {
            background-color: #fbf8be;
            color: #19384f;
        }

        select option {
            background-color: #19384f;
            color: #f0f0f7;
        }

        @media (max-width: 768px) {
            .container {
                margin: 1rem;
                padding: 1.5rem;
            }

            .schedule-entry {
                flex-direction: column;
                gap: 1rem;
            }

            .schedule-entry .actions {
                width: 100%;
                justify-content: flex-end;
            }
        }

        .weekly-schedule {
    margin-bottom: 2rem;
    background-color: #19384f;
    border-radius: 0.75rem;
    padding: 0.75rem;
    overflow-x: auto;
}

.weekly-schedule table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0.25rem;
    font-size: 0.85rem;
}

.weekly-schedule th {
    color: #fbf8be;
    padding: 0.5rem;
    text-align: center;
    font-weight: 600;
    background-color: #234e70;
    border-radius: 0.25rem;
    white-space: nowrap;
}

.weekly-schedule td {
    background-color: #234e70;
    padding: 0.5rem;
    border-radius: 0.25rem;
    vertical-align: top;
    min-height: 60px;
    transition: all 0.3s ease;
}

.schedule-item {
    padding: 0.35rem;
    margin-bottom: 0.25rem;
    background-color: #19384f;
    border-left: 2px solid #fbf8be;
    border-radius: 0.25rem;
    font-size: 0.8rem;
}

.schedule-item .subject {
    color: #fbf8be;
    font-weight: 500;
    margin-bottom: 0.1rem;
}

.schedule-item .instructor {
    color: #f0f0f7;
    font-size: 0.75rem;
    opacity: 0.9;
}

.schedule-item .group {
    display: inline-block;
    padding: 0.1rem 0.25rem;
    background-color: #234e70;
    border-radius: 0.2rem;
    font-size: 0.7rem;
    color: #fbf8be;
    margin-top: 0.1rem;
}

@media (max-width: 768px) {
    .weekly-schedule {
        padding: 0.5rem;
        margin: 0 -1rem;
        border-radius: 0;
    }
    
    .weekly-schedule table {
        font-size: 0.75rem;
    }
    
    .weekly-schedule th,
    .weekly-schedule td {
        padding: 0.35rem;
    }
    
    .schedule-item {
        padding: 0.25rem;
        font-size: 0.7rem;
    }
    
    .schedule-item .instructor {
        font-size: 0.65rem;
    }
    
    .schedule-item .group {
        font-size: 0.6rem;
        padding: 0.1rem 0.2rem;
    }
}
.section-title {
    color: #fbf8be;
    font-size: 1.3rem;
    margin: 2rem 0 1rem 0;
    border-bottom: 2px solid #234e70;
    padding-bottom: 0.5rem;
    display: inline-block;
}
    </style>
<body>
<div class="quest-long-idk">
            <img src="content-and-imgs/template.png" class="HUM" alt="" />
            <div class="where"><span class="text-where">> ControlPanel > Table Management</span></div>
            </div>
    <div class="container">
        <h3>Manage Schedule</h3>
        <div class="weekly-schedule">
    <table>
        <tbody id="scheduleGrid">
            <!-- Will be populated by JavaScript -->
        </tbody>
    </table>
</div>

<div class="section-title">Add/Edit Schedule Entry</div>
        <form id="scheduleForm">
            <input type="hidden" id="entryId" name="id">
            <div class="form-group">
                <label for="day">Day</label>
                <select id="day" name="day" required>
                    <option value="Saturday">Saturday</option>
                    <option value="Sunday">Sunday</option>
                    <option value="Monday">Monday</option>
                    <option value="Tuesday">Tuesday</option>
                    <option value="Wednesday">Wednesday</option>
                    <option value="Thursday">Thursday</option>
                </select>
            </div>
            <div class="form-group">
                <label for="time">Time Slot</label>
                <select id="time" name="time" required>
                    <option value="8-9">8-9</option>
                    <option value="9-10">9-10</option>
                    <option value="10-11">10-11</option>
                    <option value="11-12">11-12</option>
                    <option value="12-1">12-1</option>
                    <option value="1-2">1-2</option>
                    <option value="2-3">2-3</option>
                    <option value="3-4">3-4</option>
                    <option value="4-5">4-5</option>
                </select>
            </div>
            <div class="form-group">
                <label for="subject">Subject</label>
                <select id="subject" name="subject" required>
                    <?php
                    $subjects = mysqli_query($MM, "SELECT * FROM subjects");
                    while ($row = mysqli_fetch_assoc($subjects)) {
                        echo "<option value='{$row['name']}'>{$row['name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="group">Group</label>
                <select id="group" name="group" required>
                    <option value="a">Group A</option>
                    <option value="b">Group B</option>
                </select>
            </div>
            <div class="form-group">
                <label for="instructor">Instructor</label>
                <input type="text" id="instructor" name="instructor" required>
            </div>
            <div class="btn-group">
                <button type="submit" class="btn btn-primary">Save</button>
                <button type="reset" class="btn btn-danger">Clear</button>
            </div>
        </form>

        <div class="schedule-table"></div>
        
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    let currentGroup = 'a'
    function updateScheduleGrid(data) {
    const timeSlots = ['8-9', '9-10', '10-11', '11-12', '12-1', '1-2', '2-3', '3-4', '4-5'];
    const days = ['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday'];
    const grid = document.getElementById('scheduleGrid');
    grid.innerHTML = '';

    // Create header row with time slots
    const headerRow = document.createElement('tr');
    
    // Empty cell for top-left corner
    const cornerCell = document.createElement('th');
    cornerCell.style.backgroundColor = '#234e70';
    cornerCell.textContent = 'Day/Time';
    headerRow.appendChild(cornerCell);
    
    // Add time slots to header
    timeSlots.forEach(time => {
        const timeHeader = document.createElement('th');
        timeHeader.style.backgroundColor = '#234e70';
        timeHeader.style.color = '#fbf8be';
        timeHeader.style.fontWeight = '500';
        timeHeader.textContent = time;
        headerRow.appendChild(timeHeader);
    });
    
    grid.appendChild(headerRow);

    // Create rows for each day
    days.forEach(day => {
        const row = document.createElement('tr');
        
        // Day column
        const dayCell = document.createElement('td');
        dayCell.style.backgroundColor = '#234e70';
        dayCell.style.color = '#fbf8be';
        dayCell.style.fontWeight = '500';
        dayCell.textContent = day;
        row.appendChild(dayCell);

        // Process time slots
        for (let i = 0; i < timeSlots.length; i++) {
            // Skip if this slot was already handled as part of a multi-hour subject
            if (row.cells[i + 1]?.colspan) continue;

            const time = timeSlots[i];
            const cell = document.createElement('td');
            
            const currentEntry = data.find(entry => 
                entry.day_of_week === day && entry.time_slot === time
            );

            if (currentEntry) {
                // Count how many consecutive hours this subject has
                let consecutiveHours = 1;
                while (i + consecutiveHours < timeSlots.length) {
                    const nextEntry = data.find(entry =>
                        entry.day_of_week === day && 
                        entry.time_slot === timeSlots[i + consecutiveHours] &&
                        entry.subject === currentEntry.subject
                    );
                    if (nextEntry) {
                        consecutiveHours++;
                    } else {
                        break;
                    }
                }

                // Set colspan if subject spans multiple hours
                if (consecutiveHours > 1) {
                    cell.colSpan = consecutiveHours;
                }

                // Create schedule item
                const item = document.createElement('div');
                item.className = 'schedule-item';
                item.innerHTML = `
                    <div class="subject">${currentEntry.subject}</div>
                    <div class="instructor">${currentEntry.instructor}</div>
                    <div class="group">Group ${currentEntry.group_name.toUpperCase()}</div>
                `;
                cell.appendChild(item);

                // Skip the next cells that are part of this multi-hour subject
                i += consecutiveHours - 1;
            }
            
            row.appendChild(cell);
        }
        
        grid.appendChild(row);
    });
}

// Modify your existing loadSchedule function to update both views
function loadSchedule(group) {
    $.post('schedule-controller.php', {
        action: 'get',
        group: group
    }, function (response) {
        if (response.success) {
            updateScheduleTable(response.data);
            updateScheduleGrid(response.data);  // Add this line
        }
    });
}

        function updateScheduleTable(data) {
            const table = $('.schedule-table');
            table.empty();
            data.forEach(entry => {
                table.append(`
                    <div class="schedule-entry">
                        <div class="details">
                            <strong>${entry.day_of_week}</strong> | ${entry.time_slot} | ${entry.subject} | Instructor: ${entry.instructor}
                        </div>
                        <div class="actions">
                            <button class="btn btn-primary" onclick="editEntry(${entry.id})">Edit</button>
                            <button class="btn btn-danger" onclick="deleteEntry(${entry.id})">Delete</button>
                        </div>
                    </div>
                `);
            });
        }

        $('#scheduleForm').on('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            formData.append('action', $('#entryId').val() ? 'update' : 'add');

            $.ajax({
                url: 'schedule-controller.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.success) {
                        loadSchedule(currentGroup);
                        $('#scheduleForm')[0].reset();
                        $('#entryId').val('');
                    }
                    alert(response.message);
                }
            });
        });

        function editEntry(id) {
    $.post('schedule-controller.php', { action: 'getSingle', id: id }, function (response) {
        if (response.success) {
            const entry = response.data;
            $('#entryId').val(entry.id);
            $('#day').val(entry.day_of_week);
            $('#time').val(entry.time_slot);
            $('#subject').val(entry.subject);
            $('#group').val(entry.group_name);
            $('#instructor').val(entry.instructor);
        } else {
            alert(response.message);
        }
    });
}


        function deleteEntry(id) {
            if (confirm('Are you sure you want to delete this entry?')) {
                $.post('schedule-controller.php', { action: 'delete', id: id }, function (response) {
                    if (response.success) {
                        loadSchedule(currentGroup);
                    }
                    alert(response.message);
                });
            }
        }

        // Initial load
        loadSchedule(currentGroup);
    </script>
</body>
</html><?php include("script.php"); ?>

<?php
} else {
    ?>
    <script>window.location = '/controlpanel';</script>
<?php }
?>