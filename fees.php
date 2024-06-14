<?php include 'includes/db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fees</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Fees</h1>
        <a href="index.php" class="btn btn-primary mb-3">Back to Home</a>
        <a href="add_fee.php" class="btn btn-success mb-3">Add Fee</a>
        
        <?php
        $sql = "SELECT Fees.Receipt_No, Fees.Amount, Fees.Date_of_Receipt, Student.S_Name FROM Fees
                JOIN Student ON Fees.Student_ID = Student.Student_ID";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<table class="table table-striped">';
            echo '<thead><tr><th>Receipt No</th><th>Amount</th><th>Date of Receipt</th><th>Student Name</th><th>Actions</th></tr></thead><tbody>';
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>{$row['Receipt_No']}</td><td>{$row['Amount']}</td><td>{$row['Date_of_Receipt']}</td><td>{$row['S_Name']}</td>";
                echo "<td><a href='edit_fee.php?id={$row['Receipt_No']}' class='btn btn-warning btn-sm'>Edit</a> ";
                echo "<a href='delete_fee.php?id={$row['Receipt_No']}' class='btn btn-danger btn-sm'>Delete</a></td></tr>";
            }
            echo '</tbody></table>';
        } else {
            echo "<p>No fees found.</p>";
        }
        ?>
    </div>
</body>
</html>

<?php $conn->close(); ?>
