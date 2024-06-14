<?php
include 'includes/db.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $borrow_id = $_POST['borrow_id'];
    $return_date = $_POST['return_date'];
    $late_fee = $_POST['late_fee'];

    // Update Borrowed_Books table with edited details
    $update_sql = "UPDATE Borrowed_Books 
                   SET Return_Date = '$return_date', Late_Fee = $late_fee 
                   WHERE Borrow_ID = $borrow_id";

    if ($conn->query($update_sql) === TRUE) {
        header("Location: borrowed_books.php");
    } else {
        echo "Error updating Borrowed_Books table: " . $conn->error;
    }
}

// Fetch borrowed book details for editing
if (isset($_GET['id'])) {
    $borrow_id = $_GET['id'];

    // Query to get details of the borrowed book
    $borrow_sql = "SELECT bb.Borrow_ID, bb.Student_ID, bb.Book_ID, bb.Borrow_Date, bb.Due_Date, bb.Return_Date, bb.Late_Fee, l.Title
                   FROM Borrowed_Books bb
                   INNER JOIN Library l ON bb.Book_ID = l.Book_ID
                   WHERE bb.Borrow_ID = $borrow_id";

    $result = $conn->query($borrow_sql);
    $borrowed_book = $result->fetch_assoc();

    if (!$borrowed_book) {
        echo "No record found.";
        exit;
    }
} else {
    echo "Borrow ID is not specified.";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Borrowed Book</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Edit Borrowed Book Details</h1>
        <a href="borrowed_books.php" class="btn btn-primary mb-3">Back to Borrowed Books</a>
        
        <div class="card">
            <div class="card-header">
                <h4><?php echo $borrowed_book['Title']; ?></h4>
            </div>
            <div class="card-body">
                <form method="POST" action="edit_borrowed_book.php">
                    <div class="form-group">
                        <label for="borrow_id">Borrow ID</label>
                        <input type="text" class="form-control" id="borrow_id" name="borrow_id" value="<?php echo $borrowed_book['Borrow_ID']; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="return_date">Return Date</label>
                        <input type="date" class="form-control" id="return_date" name="return_date" value="<?php echo $borrowed_book['Return_Date']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="late_fee">Late Fee</label>
                        <input type="number" step="0.01" min="0" class="form-control" id="late_fee" name="late_fee" value="<?php echo $borrowed_book['Late_Fee']; ?>" placeholder="Enter late fee amount">
                    </div>
                    <button type="submit" class="btn btn-success">Save Changes</button>
                </form>
            </div>
            <div class="card-footer text-muted">
                Borrowed Date: <?php echo $borrowed_book['Borrow_Date']; ?> | Due Date: <?php echo $borrowed_book['Due_Date']; ?>
            </div>
        </div>
    </div>
</body>
</html>
