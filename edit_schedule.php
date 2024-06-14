<?php
include 'includes/db.php';

if (isset($_GET['id'])) {
    $schedule_id = $_GET['id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $course_id = $_POST['course_id'];
        $day = $_POST['day'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];
        $room_no = $_POST['room_no'];

        $sql = "UPDATE Class_Schedule SET 
                Course_ID='$course_id', 
                Day='$day', 
                Start_Time='$start_time', 
                End_Time='$end_time', 
                Room_No='$room_no' 
                WHERE Schedule_ID=$schedule_id";

        if ($conn->query($sql) === TRUE) {
            header("Location: schedule.php");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        $sql = "SELECT * FROM Class_Schedule WHERE Schedule_ID=$schedule_id";
        $result = $conn->query($sql);
        $schedule = $result->fetch_assoc();
    }
} else {
    header("Location: schedule.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Schedule</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Edit Schedule</h1>
        <a href="schedule.php" class="btn btn-primary mb-3">Back to Schedule</a>
        
        <form method="POST" action="edit_schedule.php?id=<?php echo $schedule_id; ?>">
            <div class="form-group">
                <label for="course_id">Course ID</label>
                <input type="number" class="form-control" id="course_id" name="course_id" value="<?php echo $schedule['Course_ID']; ?>" required>
            </div>
            <div class="form-group">
                <label for="day">Day</label>
                <select class="form-control" id="day" name="day" required>
                    <option value="Monday" <?php if ($schedule['Day'] == 'Monday') echo 'selected'; ?>>Monday</option>
                    <option value="Tuesday" <?php if ($schedule['Day'] == 'Tuesday') echo 'selected'; ?>>Tuesday</option>
                    <option value="Wednesday" <?php if ($schedule['Day'] == 'Wednesday') echo 'selected'; ?>>Wednesday</option>
                    <option value="Thursday" <?php if ($schedule['Day'] == 'Thursday') echo 'selected'; ?>>Thursday</option>
                    <option value="Friday" <?php if ($schedule['Day'] == 'Friday') echo 'selected'; ?>>Friday</option>
                    <option value="Saturday" <?php if ($schedule['Day'] == 'Saturday') echo 'selected'; ?>>Saturday</option>
                    <option value="Sunday" <?php if ($schedule['Day'] == 'Sunday') echo 'selected'; ?>>Sunday</option>
                </select>
            </div>
            <div class="form-group">
                <label for="start_time">Start Time</label>
                <input type="time" class="form-control" id="start_time" name="start_time" value="<?php echo $schedule['Start_Time']; ?>" required>
            </div>
            <div class="form-group">
                <label for="end_time">End Time</label>
                <input type="time" class="form-control" id="end_time" name="end_time" value="<?php echo $schedule['End_Time']; ?>" required>
            </div>
            <div class="form-group">
                <label for="room_no">Room No</label>
                <input type="text" class="form-control" id="room_no" name="room_no" value="<?php echo $schedule['Room_No']; ?>">
            </div>
            <button type="submit" class="btn btn-warning">Update Schedule</button>
        </form>
    </div>
</body>
</html>

<?php $conn->close(); ?>
