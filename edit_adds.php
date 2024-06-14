<?php
include 'includes/db.php';

// Fetch administrators and students for dropdowns
$admin_sql = "SELECT Admin_ID, Admin_Name FROM Administrator ORDER BY Admin_Name";
$student_sql = "SELECT Student_ID, S_Name FROM Student ORDER BY S_Name"; // Modify as needed

$admin_result = $conn->query($admin_sql);
$student_result = $conn->query($student_sql);

// Retrieve admin and student IDs from the query string
$admin_id = $_GET['admin_id'];
$student_id = $_GET['student_id'];

// Fetch current details of the Adds record
$select_sql = "SELECT Admin_ID, Student_ID, Date_Added FROM Adds WHERE Admin_ID = '$admin_id' AND Student_ID = '$student_id'";
$result = $conn->query($select_sql);
$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_admin_id = $_POST['admin_id'];
    $new_student_id = $_POST['student_id'];
    $new_date_added = $_POST['date_added'];

    // Update record in Adds table
    $update_sql = "UPDATE Adds
                   SET Admin_ID = '$new_admin_id', Student_ID = '$new_student_id', Date_Added = '$new_date_added'
                   WHERE Admin_ID = '$admin_id' AND Student_ID = '$student_id'";

    if ($conn->query($update_sql) === TRUE) {
        header("Location: list_adds.php");
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Record in Adds Table</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Edit Record in Adds Table</h1>
        <a href="list_adds.php" class="btn btn-primary mb-3">Back to List</a>
        
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] . "?admin_id=$admin_id&student_id=$student_id"; ?>">
            <div class="form-group">
                <label for="admin_id">Administrator</label>
                <select class="form-control" id="admin_id" name="admin_id" required>
                    <?php while ($admin = $admin_result->fetch_assoc()) : ?>
                        <option value="<?php echo $admin['Admin_ID']; ?>" <?php echo ($admin['Admin_ID'] == $row['Admin_ID']) ? 'selected' : ''; ?>>
                            <?php echo $admin['Admin_Name']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="student_id">Student</label>
                <select class="form-control" id="student_id" name="student_id" required>
                    <?php while ($student = $student_result->fetch_assoc()) : ?>
                        <option value="<?php echo $student['Student_ID']; ?>" <?php echo ($student['Student_ID'] == $row['Student_ID']) ? 'selected' : ''; ?>>
                            <?php echo $student['S_Name']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="date_added">Date Added</label>
                <input type="date" class="form-control" id="date_added" name="date_added" value="<?php echo $row['Date_Added']; ?>" required>
            </div>
            <button type="submit" class="btn btn-success">Update Record</button>
        </form>
    </div>
</body>
</html>
