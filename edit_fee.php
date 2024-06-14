<?php
include 'includes/db.php';

if (isset($_GET['id'])) {
    $receipt_no = $_GET['id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $amount = $_POST['amount'];
        $date_of_receipt = $_POST['date_of_receipt'];
        $student_id = $_POST['student_id'];

        $sql = "UPDATE Fees SET 
                Amount='$amount', Date_of_Receipt='$date_of_receipt', Student_ID='$student_id'
                WHERE Receipt_No=$receipt_no";

        if ($conn->query($sql) === TRUE) {
            header("Location: fees.php");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        $sql = "SELECT * FROM Fees WHERE Receipt_No=$receipt_no";
        $result = $conn->query($sql);
        $fee = $result->fetch_assoc();
    }
} else {
    header("Location: fees.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Fee</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Edit Fee</h1>
        <a href="fees.php" class="btn btn-primary mb-3">Back to Fees</a>
        
        <form method="POST" action="edit_fee.php?id=<?php echo $receipt_no; ?>">
            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="number" step="0.01" class="form-control" id="amount" name="amount" value="<?php echo $fee['Amount']; ?>" required>
            </div>
            <div class="form-group">
                <label for="date_of_receipt">Date of Receipt</label>
                <input type="date" class="form-control" id="date_of_receipt" name="date_of_receipt" value="<?php echo $fee['Date_of_Receipt']; ?>" required>
            </div>
            <div class="form-group">
                <label for="student_id">Student ID</label>
                <input type="number" class="form-control" id="student_id" name="student_id" value="<?php echo $fee['Student_ID']; ?>" required>
            </div>
            <button type="submit" class="btn btn-warning">Update Fee</button>
        </form>
    </div>
</body>
</html>

<?php $conn->close(); ?>
