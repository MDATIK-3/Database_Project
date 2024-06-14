<?php
session_start();
include 'includes/db.php';

// Function to sanitize input data
function sanitize($conn, $data) {
    return mysqli_real_escape_string($conn, htmlspecialchars(strip_tags($data)));
}

// Initialize variables
$email = '';
$password = '';
$error = '';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize input data
    $email = sanitize($conn, $_POST['email']);
    $password = sanitize($conn, $_POST['password']);

    // Prepare and bind SQL statement
    $stmt = $conn->prepare("SELECT Admin_ID, Admin_Name, Password FROM Administrator WHERE Email = ?");
    $stmt->bind_param("s", $email);

    // Execute query
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists and password is correct
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['Password'];

        // Verify password
        if ($password === $hashed_password) { // Use password_verify($password, $hashed_password) if passwords are hashed
            // Password is correct, set session variables
            $_SESSION['admin_id'] = $row['Admin_ID'];
            $_SESSION['admin_name'] = $row['Admin_Name'];

            // Redirect to index.html or any other page
            header("Location: index.php");
            exit();
        } else {
            $error = "Invalid email or password.";
        }
    } else {
        $error = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Student Management System</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .btn-primary {
            width: 100%;
        }

        .alert {
            display: <?php echo (!empty($error)) ? 'block' : 'none'; ?>;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2 class="text-center">Admin Login</h2>
        <form id="loginForm" method="POST" action="">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
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
