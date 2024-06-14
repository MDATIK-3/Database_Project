<?php
include 'includes/db.php';

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

    $sql = "INSERT INTO Student (S_Name, Address, Contact_No, Date_of_Birth, Gender, Email, Guardian_Name, Guardian_Contact_No, Enrollment_Date)
            VALUES ('$name', '$address', '$contact', '$dob', '$gender', '$email', '$guardian_name', '$guardian_contact', '$enrollment_date')";

    if ($conn->query($sql) === TRUE) {
        header("Location: students.php");
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
    <title>Add Student</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Add Student</h1>
        <a href="students.php" class="btn btn-primary mb-3">Back to Students</a>
        
        <form method="POST" action="add_student.php">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" name="address">
            </div>
            <div class="form-group">
                <label for="contact">Contact No</label>
                <input type="text" class="form-control" id="contact" name="contact">
            </div>
            <div class="form-group">
                <label for="dob">Date of Birth</label>
                <input type="date" class="form-control" id="dob" name="dob">
            </div>
            <div class="form-group">
                <label for="gender">Gender</label>
                <select class="form-control" id="gender" name="gender">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="guardian_name">Guardian Name</label>
                <input type="text" class="form-control" id="guardian_name" name="guardian_name">
            </div>
            <div class="form-group">
                <label for="guardian_contact">Guardian Contact No</label>
                <input type="text" class="form-control" id="guardian_contact" name="guardian_contact">
            </div>
            <div class="form-group">
                <label for="enrollment_date">Enrollment Date</label>
                <input type="date" class="form-control" id="enrollment_date" name="enrollment_date" required>
            </div>
            <button type="submit" class="btn btn-success">Add Student</button>
        </form>
    </div>
</body>
</html>

<?php $conn->close(); ?>
