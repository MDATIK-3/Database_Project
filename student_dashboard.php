<!DOCTYPE html>
<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

// Fetch student information
$sql_student = "SELECT * FROM Student WHERE Student_ID = ?";
$stmt_student = $conn->prepare($sql_student);
$stmt_student->bind_param("i", $student_id);
$stmt_student->execute();
$result_student = $stmt_student->get_result();
$student_info = $result_student->fetch_assoc();

// Fetch enrolled courses
$sql_courses = "SELECT Course.C_Name, Enrollment.Enrollment_Date FROM Enrollment 
                JOIN Course ON Enrollment.Course_ID = Course.Course_ID 
                WHERE Enrollment.Student_ID = ?";
$stmt_courses = $conn->prepare($sql_courses);
$stmt_courses->bind_param("i", $student_id);
$stmt_courses->execute();
$result_courses = $stmt_courses->get_result();

// Fetch borrowed books
$sql_books = "SELECT Library.Title, Borrowed_Books.Borrow_Date, Borrowed_Books.Due_Date 
              FROM Borrowed_Books 
              JOIN Library ON Borrowed_Books.Book_ID = Library.Book_ID 
              WHERE Borrowed_Books.Student_ID = ? AND Borrowed_Books.Return_Date IS NULL";
$stmt_books = $conn->prepare($sql_books);
$stmt_books->bind_param("i", $student_id);
$stmt_books->execute();
$result_books = $stmt_books->get_result();

// Fetch fee details
$sql_fees = "SELECT * FROM Fees WHERE Student_ID = ?";
$stmt_fees = $conn->prepare($sql_fees);
$stmt_fees->bind_param("i", $student_id);
$stmt_fees->execute();
$result_fees = $stmt_fees->get_result();

// Fetch class schedule
$sql_schedule = "SELECT Course.C_Name, Class_Schedule.Day, Class_Schedule.Start_Time, Class_Schedule.End_Time 
                FROM Class_Schedule
                JOIN Course ON Class_Schedule.Course_ID = Course.Course_ID
                WHERE Class_Schedule.Course_ID IN (SELECT Course_ID FROM Enrollment WHERE Student_ID = ?)";
$stmt_schedule = $conn->prepare($sql_schedule);
$stmt_schedule->bind_param("i", $student_id);
$stmt_schedule->execute();
$result_schedule = $stmt_schedule->get_result();

// Fetch attendance details
$sql_attendance = "SELECT Date, Status FROM Attendance WHERE Student_ID = ?";
$stmt_attendance = $conn->prepare($sql_attendance);
$stmt_attendance->bind_param("i", $student_id);
$stmt_attendance->execute();
$result_attendance = $stmt_attendance->get_result();

$sql_department = "SELECT d.Department_Name 
                   FROM Department AS d
                   JOIN Course AS c ON d.Dept_ID = c.Dept_ID
                   JOIN Enrollment AS e ON e.Course_ID = c.Course_ID
                   JOIN Student AS s ON s.Student_ID = e.Student_ID
                   WHERE s.Student_ID = ?";
$stmt_department = $conn->prepare($sql_department);
$stmt_department->bind_param("i", $student_id);
$stmt_department->execute();
$result_department = $stmt_department->get_result();

// Check if department information is fetched successfully
if ($result_department->num_rows > 0) {
    $department_info = $result_department->fetch_assoc();
} else {
    // Handle case where department information is not found
    $department_info = array('Department_Name' => 'Department Not Found');
}

// Fetch exam scores
$sql_scores = "SELECT Course.C_Name, Exam_Scores.Marks_Obtained FROM Exam_Scores
               JOIN Exams ON Exam_Scores.Exam_ID = Exams.Exam_ID
               JOIN Course ON Exams.Course_ID = Course.Course_ID
               WHERE Exam_Scores.Student_ID = ?";
$stmt_scores = $conn->prepare($sql_scores);
$stmt_scores->bind_param("i", $student_id);
$stmt_scores->execute();
$result_scores = $stmt_scores->get_result();

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
        }

        .dashboard-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 800px;
            animation: fadeIn 1s ease-in-out;
        }

        .dashboard-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .card {
            margin-bottom: 20px;
            transition: transform 0.2s ease-in-out;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .alert {
            display: <?php echo (!empty($error)) ? 'block' : 'none'; ?>;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .book-card {
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .book-card:hover {
            background-color: #e9ecef;
        }
    </style>
</head>

<body>
    <div class="dashboard-container">
        <h2 class="dashboard-header">Welcome, <?php echo htmlspecialchars($student_info['S_Name']); ?></h2>

        <div class="card">
            <div class="card-header">
                <h5>Student Information</h5>
            </div>
            <div class="card-body">
                <p><strong>Name:</strong> <?php echo htmlspecialchars($student_info['S_Name']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($student_info['Email']); ?></p>
                <p><strong>Address:</strong> <?php echo htmlspecialchars($student_info['Address']); ?></p>
                <p><strong>Contact No:</strong> <?php echo htmlspecialchars($student_info['Contact_No']); ?></p>
                <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($student_info['Date_of_Birth']); ?></p>
                <p><strong>Gender:</strong> <?php echo htmlspecialchars($student_info['Gender']); ?></p>
                <p><strong>Guardian Name:</strong> <?php echo htmlspecialchars($student_info['Guardian_Name']); ?></p>
                <p><strong>Guardian Contact No:</strong> <?php echo htmlspecialchars($student_info['Guardian_Contact_No']); ?></p>
                <p><strong>Enrollment Date:</strong> <?php echo htmlspecialchars($student_info['Enrollment_Date']); ?></p>
                <p><strong>Department:</strong> <?php echo isset($department_info['Department_Name']) ? htmlspecialchars($department_info['Department_Name']) : 'N/A'; ?></p>
                </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>Enrolled Courses</h5>
            </div>
            <div class="card-body">
                <?php while ($course = $result_courses->fetch_assoc()): ?>
                    <p><strong>Course Name:</strong> <?php echo htmlspecialchars($course['C_Name']); ?></p>
                    <p><strong>Enrollment Date:</strong> <?php echo htmlspecialchars($course['Enrollment_Date']); ?></p>
                <?php endwhile; ?>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>Borrowed Books</h5>
            </div>
            <div class="card-body">
                <?php while ($book = $result_books->fetch_assoc()): ?>
                    <p><strong>Book Title:</strong> <?php echo htmlspecialchars($book['Title']); ?></p>
                    <p><strong>Borrow Date:</strong> <?php echo htmlspecialchars($book['Borrow_Date']); ?></p>
                    <p><strong>Due Date:</strong> <?php echo htmlspecialchars($book['Due_Date']); ?></p>
                <?php endwhile; ?>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>Fee Details</h5>
            </div>
            <div class="card-body">
                <?php while ($fee = $result_fees->fetch_assoc()): ?>
                    <p><strong>Receipt No:</strong> <?php echo htmlspecialchars($fee['Receipt_No']); ?></p>
                    <p><strong>Amount:</strong> <?php echo htmlspecialchars($fee['Amount']); ?></p>
                    <p><strong>Date of Receipt:</strong> <?php echo htmlspecialchars($fee['Date_of_Receipt']); ?></p>
                <?php endwhile; ?>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>Class Schedule</h5>
            </div>
            <div class="card-body">
                <?php while ($schedule = $result_schedule->fetch_assoc()): ?>
                    <p><strong>Course Name:</strong> <?php echo htmlspecialchars($schedule['C_Name']); ?></p>
                    <p><strong>Day:</strong> <?php echo htmlspecialchars($schedule['Day']); ?></p>
                    <p><strong>Time:</strong> <?php echo htmlspecialchars($schedule['Start_Time']) . ' - ' . htmlspecialchars($schedule['End_Time']); ?></p>
                <?php endwhile; ?>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>Attendance Details</h5>
            </div>
            <div class="card-body">
                <?php while ($attendance = $result_attendance->fetch_assoc()): ?>
                    <p><strong>Status:</strong> <?php echo htmlspecialchars($attendance['Status']); ?></p>
                <?php endwhile; ?>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>Exam Scores</h5>
            </div>
            <div class="card-body">
                <?php while ($score = $result_scores->fetch_assoc()): ?>
                    <p><strong>Course Name:</strong> <?php echo htmlspecialchars($score['C_Name']); ?></p>
                    <p><strong>Score:</strong> <?php echo htmlspecialchars($score['Marks_Obtained']); ?></p>
                <?php endwhile; ?>
            </div>
        </div>

    </div>

    <script>
        function borrowBook(bookId) {
            if (confirm("Are you sure you want to borrow this book?")) {
                fetch('borrow_book.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'book_id=' + bookId + '&student_id=<?php echo $student_id; ?>'
                })
                    .then(response => response.text())
                    .then(data => {
                        alert(data);
                        location.reload();
                    });
            }
        }
    </script>
</body>

</html>
