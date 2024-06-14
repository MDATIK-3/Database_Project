<?php
include 'includes/db.php';

if (isset($_GET['id'])) {
    $admin_id = $_GET['id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $contact_no = $_POST['contact_no'];
        $date_joined = $_POST['date_joined'];

        $sql = "UPDATE Administrator SET 
                Admin_Name='$name', Password='$password', Email='$email', Contact_No='$contact_no', Date_Joined='$date_joined'
                WHERE Admin_ID=$admin_id";

        if ($conn->query($sql) === TRUE) {
            header("Location: administrators.php");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        $sql = "SELECT * FROM Administrator WHERE Admin_ID=$admin_id";
        $result = $conn->query($sql);
        $admin = $result->fetch_assoc();
    }
} else {
    header("Location: administrators.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Administrator</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Edit Administrator</h1>
        <a href="administrators.php" class="btn btn-primary mb-3">Back to Administrators</a>
        
        <form method="POST" action="edit_administrator.php?id=<?php echo $admin_id; ?>">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $admin['Admin_Name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" value="<?php echo $admin['Password']; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $admin['Email']; ?>" required>
            </div>
            <div class="form-group">
                <label for="contact_no">Contact No</label>
                <input type="text" class="form-control" id="contact_no" name="contact_no" value="<?php echo $admin['Contact_No']; ?>">
            </div>
            <div class="form-group">
                <label for="date_joined">Date Joined</label>
                <input type="date" class="form-control" id="date_joined" name="date_joined" value="<?php echo $admin['Date_Joined']; ?>" required>
            </div>
            <button type="submit" class="btn btn-warning">Update Administrator</button>
        </form>
    </div>
</body>
</html>

<?php $conn->close(); ?>
