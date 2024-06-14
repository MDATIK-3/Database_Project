<?php
session_start();
include 'includes/db.php';

// Function to sanitize input data
function sanitize($conn, $data) {
    return mysqli_real_escape_string($conn, htmlspecialchars(strip_tags($data)));
}

// Initialize variables
$email = '';
$student_id = '';
$error = '';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize input data
    $email = sanitize($conn, $_POST['email']);
    $student_id = sanitize($conn, $_POST['student_id']);

    // Prepare and bind SQL statement
    $stmt = $conn->prepare("SELECT Student_ID, S_Name FROM Student WHERE Email = ?");
    $stmt->bind_param("s", $email);

    // Execute query
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists and student ID is correct
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stored_student_id = $row['Student_ID'];

        // Verify student ID
        if ($student_id == $stored_student_id) {
            // Student ID is correct, set session variables
            $_SESSION['student_id'] = $row['Student_ID'];
            $_SESSION['student_name'] = $row['S_Name'];

            // Redirect to student dashboard or any other page
            header("Location: student_dashboard.php");
            exit();
        } else {
            $error = "Invalid email or student ID.";
        }
    } else {
        $error = "Invalid email or student ID.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login - Student Management System</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('https://myrepublica.nagariknetwork.com/uploads/media/stuydtips_20191219162831.jpeg');
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            animation: fadeIn 1.5s ease-in-out;
            margin: 0;
        }

        .login-container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 350px;
            animation: slideIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideIn {
            from { transform: translateY(50px); }
            to { transform: translateY(0); }
        }

        .form-group {
            margin-bottom: 15px;
        }

        .btn-primary {
            width: 100%;
            background-color: #007bff;
            border: none;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .alert {
            display: <?php echo (!empty($error)) ? 'block' : 'none'; ?>;
        }

        .animated-title {
            font-size: 1.5rem;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2 class="text-center animated-title">Student Login</h2>
        <form id="loginForm" method="POST" action="">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>
            <div class="form-group">
                <label for="student_id">Student ID</label>
                <input type="password" class="form-control" id="student_id" name="student_id" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
            <?php if (!empty($error)) : ?>
                <div class="alert alert-danger mt-3" role="alert">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
