<?php
include 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $amount = $_POST['amount'];
    $date_of_receipt = $_POST['date_of_receipt'];
    $student_id = $_POST['student_id'];

    $sql = "INSERT INTO Fees (Amount, Date_of_Receipt, Student_ID)
            VALUES ('$amount', '$date_of_receipt', '$student_id')";

    if ($conn->query($sql) === TRUE) {
        header("Location: fees.php");
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
    <title>Add Fee</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Add Fee</h1>
        <a href="fees.php" class="btn btn-primary mb-3">Back to Fees</a>
        
        <form method="POST" action="add_fee.php">
            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="number" step="0.01" class="form-control" id="amount" name="amount" required>
            </div>
            <div class="form-group">
                <label for="date_of_receipt">Date of Receipt</label>
                <input type="date" class="form-control" id="date_of_receipt" name="date_of_receipt" required>
            </div>
            <div class="form-group">
                <label for="student_id">Student ID</label>
                <input type="number" class="form-control" id="student_id" name="student_id" required>
            </div>
            <button type="submit" class="btn btn-success">Add Fee</button>
        </form>
    </div>
</body>
</html>

<?php $conn->close(); ?>
