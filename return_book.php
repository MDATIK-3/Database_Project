<?php
include 'includes/db.php';

$book_details = null;
$error = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $borrow_id = $_POST['borrow_id'];
    $return_date = $_POST['return_date'];

    // Retrieve the Book ID and Due Date from the Borrowed_Books table
    $sql = "SELECT Book_ID, Due_Date FROM Borrowed_Books WHERE Borrow_ID = $borrow_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $book_id = $row['Book_ID'];
        $due_date = $row['Due_Date'];

        // Calculate late fee if the book is returned after the due date
        $late_fee = 0.00;
        $due_date_time = strtotime($due_date);
        $return_date_time = strtotime($return_date);
        if ($return_date_time > $due_date_time) {
            $days_late = ($return_date_time - $due_date_time) / (60 * 60 * 24);
            $late_fee = $days_late * 5.00; // Assuming a late fee of 5.00 per day
        }

        // Update the Borrowed_Books table with the return date and late fee
        $update_sql = "UPDATE Borrowed_Books SET Return_Date = '$return_date', Late_Fee = $late_fee WHERE Borrow_ID = $borrow_id";
        if ($conn->query($update_sql) === TRUE) {
            // Update available quantity in Library table (assuming available quantity increases by 1)
            $library_update_sql = "UPDATE Library SET Available = Available + 1 WHERE Book_ID = $book_id";
            $conn->query($library_update_sql);

            // Fetch book details to display
            $book_sql = "SELECT b.Title, b.Author, bb.Borrow_Date, bb.Due_Date, bb.Return_Date, bb.Late_Fee 
                         FROM Library b
                         JOIN Borrowed_Books bb ON b.Book_ID = bb.Book_ID
                         WHERE bb.Borrow_ID = $borrow_id";
            $book_result = $conn->query($book_sql);
            if ($book_result->num_rows > 0) {
                $book_details = $book_result->fetch_assoc();
            }
        } else {
            $error = "Error: " . $update_sql . "<br>" . $conn->error;
        }
    } else {
        $error = "Error: Borrow ID not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Return Book</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Return Book</h1>
        <a href="index.php" class="btn btn-primary mb-3">Back to Home</a>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="return_book.php">
            <div class="form-group">
                <label for="borrow_id">Borrow ID</label>
                <input type="number" class="form-control" id="borrow_id" name="borrow_id" required>
            </div>
            <div class="form-group">
                <label for="return_date">Return Date</label>
                <input type="date" class="form-control" id="return_date" name="return_date" required>
            </div>
            <button type="submit" class="btn btn-success">Return Book</button>
        </form>

        <?php if ($book_details): ?>
            <div class="mt-5">
                <h2>Book Return Details</h2>
                <p><strong>Title:</strong> <?php echo $book_details['Title']; ?></p>
                <p><strong>Author:</strong> <?php echo $book_details['Author']; ?></p>
                <p><strong>Borrow Date:</strong> <?php echo $book_details['Borrow_Date']; ?></p>
                <p><strong>Due Date:</strong> <?php echo $book_details['Due_Date']; ?></p>
                <p><strong>Return Date:</strong> <?php echo $book_details['Return_Date']; ?></p>
                <p><strong>Late Fee:</strong> $<?php echo number_format($book_details['Late_Fee'], 2); ?></p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>

<?php $conn->close(); ?>
