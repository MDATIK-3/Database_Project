<?php
include 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $contact_no = $_POST['contact_no'];
    $date_joined = $_POST['date_joined'];

    $sql = "INSERT INTO Administrator (Admin_Name, Password, Email, Contact_No, Date_Joined)
            VALUES (?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssss", $name, $password, $email, $contact_no, $date_joined);

        if ($stmt->execute()) {
            header("Location: administrators.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $stmt->error;
        }

        $stmt->close();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Administrator</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Add Administrator</h1>
        <a href="administrators.php" class="btn btn-primary mb-3">Back to Administrators</a>
        
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="contact_no">Contact No</label>
                <input type="text" class="form-control" id="contact_no" name="contact_no" required>
            </div>
            <div class="form-group">
                <label for="date_joined">Date Joined</label>
                <input type="date" class="form-control" id="date_joined" name="date_joined" required>
            </div>
            <button type="submit" class="btn btn-success">Add Administrator</button>
        </form>
    </div>
</body>
</html>
