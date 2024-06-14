<?php include 'includes/db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Information</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Student Information</h1>
        <form method="GET" class="mt-3 mb-5">
            <div class="form-group">
                <label for="student_id">Enter Student ID:</label>
                <input type="text" class="form-control" id="student_id" name="student_id" required>
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

        <?php
        if (isset($_GET['student_id'])) {
            $student_id = $_GET['student_id'];
            
            // Query for student details
            $sql = "SELECT * FROM Student WHERE Student_ID = $student_id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $student = $result->fetch_assoc();
                echo "<h2>Student Details</h2>";
                echo "<p><strong>Name:</strong> " . $student['S_Name'] . "</p>";
                echo "<p><strong>Address:</strong> " . $student['Address'] . "</p>";
                echo "<p><strong>Contact No:</strong> " . $student['Contact_No'] . "</p>";
                echo "<p><strong>Date of Birth:</strong> " . $student['Date_of_Birth'] . "</p>";
                echo "<p><strong>Gender:</strong> " . $student['Gender'] . "</p>";
                echo "<p><strong>Email:</strong> " . $student['Email'] . "</p>";
                echo "<p><strong>Guardian Name:</strong> " . $student['Guardian_Name'] . "</p>";
                echo "<p><strong>Guardian Contact No:</strong> " . $student['Guardian_Contact_No'] . "</p>";
                echo "<p><strong>Enrollment Date:</strong> " . $student['Enrollment_Date'] . "</p>";

                // Retrieve and display data from other tables
                $tables = [
                    'Fees' => "SELECT * FROM Fees WHERE Student_ID = $student_id",
                    'Exam Scores' => "SELECT * FROM Exam_Scores WHERE Student_ID = $student_id",
                    'Attendance' => "SELECT * FROM Attendance WHERE Student_ID = $student_id",
                    'Borrowed Books' => "SELECT * FROM Borrowed_Books WHERE Student_ID = $student_id",
                    'Enrollment' => "SELECT * FROM Enrollment JOIN Course ON Enrollment.Course_ID = Course.Course_ID WHERE Student_ID = $student_id"
                ];

                foreach ($tables as $title => $query) {
                    $result = $conn->query($query);
                    if ($result->num_rows > 0) {
                        echo "<h3>$title</h3>";
                        echo "<table class='table table-striped'>";
                        echo "<thead><tr>";

                        // Print table headers
                        $fields = $result->fetch_fields();
                        foreach ($fields as $field) {
                            echo "<th>" . $field->name . "</th>";
                        }
                        echo "</tr></thead><tbody>";

                        // Print table rows
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            foreach ($row as $data) {
                                echo "<td>$data</td>";
                            }
                            echo "</tr>";
                        }
                        echo "</tbody></table>";
                    } else {
                        echo "<p>No data found in $title</p>";
                    }
                }
            } else {
                echo "<p>No student found with ID $student_id</p>";
            }
        }

        $conn->close();
        ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
