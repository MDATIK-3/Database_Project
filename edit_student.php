<?php
include 'includes/db.php';

if (isset($_GET['id'])) {
    $student_id = $_GET['id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $address = $_POST['address'];
        $contact = $_POST['contact'];
        $dob = $_POST['dob'];
        $gender = $_POST['gender'];
        $email = $_POST['email'];
        $guardian_name = $_POST['guardian_name'];
        $guardian_contact = $_POST['guardian_contact'];
        $enrollment_date = $_POST['enrollment_date'];

        $sql = "UPDATE Student SET 
                S_Name='$name', 
                Address='$address', 
                Contact_No='$contact', 
                Date_of_Birth='$dob', 
                Gender='$gender', 
                Email='$email', 
                Guardian_Name='$guardian_name', 
                Guardian_Contact_No='$guardian_contact', 
                Enrollment_Date='$enrollment_date' 
                WHERE Student_ID=$student_id";

        if ($conn->query($sql) === TRUE) {
            header("Location: students.php");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        $sql = "SELECT * FROM Student WHERE Student_ID=$student_id";
        $result = $conn->query($sql);
        $student = $result->fetch_assoc();
    }
} else {
    header("Location: students.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Edit Student</h1>
        <a href="students.php" class="btn btn-primary mb-3">Back to Students</a>
        
        <form method="POST" action="edit_student.php?id=<?php echo $student_id; ?>">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $student['S_Name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" name="address" value="<?php echo $student['Address']; ?>">
            </div>
            <div class="form-group">
                <label for="contact">Contact No</label>
                <input type="text" class="form-control" id="contact" name="contact" value="<?php echo $student['Contact_No']; ?>">
            </div>
            <div class="form-group">
                <label for="dob">Date of Birth</label>
                <input type="date" class="form-control" id="dob" name="dob" value="<?php echo $student['Date_of_Birth']; ?>">
            </div>
            <div class="form-group">
                <label for="gender">Gender</label>
                <select class="form-control" id="gender" name="gender">
                    <option value="Male" <?php if ($student['Gender'] == 'Male') echo 'selected'; ?>>Male</option>
                    <option value="Female" <?php if ($student['Gender'] == 'Female') echo 'selected'; ?>>Female</option>
                    <option value="Other" <?php if ($student['Gender'] == 'Other') echo 'selected'; ?>>Other</option>
                </select>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $student['Email']; ?>" required>
            </div>
            <div class="form-group">
                <label for="guardian_name">Guardian Name</label>
                <input type="text" class="form-control" id="guardian_name" name="guardian_name" value="<?php echo $student['Guardian_Name']; ?>">
            </div>
            <div class="form-group">
                <label for="guardian_contact">Guardian Contact No</label>
                <input type="text" class="form-control" id="guardian_contact" name="guardian_contact" value="<?php echo $student['Guardian_Contact_No']; ?>">
            </div>
            <div class="form-group">
                <label for="enrollment_date">Enrollment Date</label>
                <input type="date" class="form-control" id="enrollment_date" name="enrollment_date" value="<?php echo $student['Enrollment_Date']; ?>" required>
            </div>
            <button type="submit" class="btn btn-warning">Update Student</button>
        </form>
    </div>
</body>
</html>

<?php $conn->close(); ?>
