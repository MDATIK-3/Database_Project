<?php
include 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_id = $_POST['course_id'];
    $day = $_POST['day'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $room_no = $_POST['room_no'];

    $sql = "INSERT INTO Class_Schedule (Course_ID, Day, Start_Time, End_Time, Room_No)
            VALUES ('$course_id', '$day', '$start_time', '$end_time', '$room_no')";

    if ($conn->query($sql) === TRUE) {
        header("Location: schedule.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Schedule</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Add Schedule</h1>
        <a href="schedule.php" class="btn btn-primary mb-3">Back to Schedule</a>
        
        <form method="POST" action="add_schedule.php">
            <div class="form-group">
                <label for="course_id">Course ID</label>
                <input type="number" class="form-control" id="course_id" name="course_id" required>
            </div>
            <div class="form-group">
                <label for="day">Day</label>
                <select class="form-control" id="day" name="day" required>
                    <option value="Monday">Monday</option>
                    <option value="Tuesday">Tuesday</option>
                    <option value="Wednesday">Wednesday</option>
                    <option value="Thursday">Thursday</option>
                    <option value="Friday">Friday</option>
                    <option value="Saturday">Saturday</option>
                    <option value="Sunday">Sunday</option>
                </select>
            </div>
            <div class="form-group">
                <label for="start_time">Start Time</label>
                <input type="time" class="form-control" id="start_time" name="start_time" required>
            </div>
            <div class="form-group">
                <label for="end_time">End Time</label>
                <input type="time" class="form-control" id="end_time" name="end_time" required>
            </div>
            <div class="form-group">
                <label for="room_no">Room No</label>
                <input type="text" class="form-control" id="room_no" name="room_no">
            </div>
            <button type="submit" class="btn btn-success">Add Schedule</button>
        </form>
    </div>
</body>
</html>

<?php $conn->close(); ?>
