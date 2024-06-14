<?php
include 'includes/db.php';

$error = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $book_id = $_POST['book_id'];
    $borrow_date = $_POST['borrow_date'];
    $due_date = $_POST['due_date'];

    // Insert the borrow record
    $sql = "INSERT INTO Borrowed_Books (Student_ID, Book_ID, Borrow_Date, Due_Date)
            VALUES ($student_id, $book_id, '$borrow_date', '$due_date')";

    if ($conn->query($sql) === TRUE) {
        // Update available quantity in Library table
        $update_sql = "UPDATE Library SET Available = Available - 1 WHERE Book_ID = $book_id";
        if ($conn->query($update_sql) === TRUE) {
            header("Location: borrow_book.php");
            exit;
        } else {
            $error = "Error updating Library table: " . $conn->error;
        }
    } else {
        $error = "Error inserting borrow record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrow Book</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Borrow Book</h1>
        <a href="index.php" class="btn btn-primary mb-3">Back to Home</a>
        
        <form method="POST" action="borrow_book.php">
            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>

            <div class="form-group">
                <label for="student_id">Student ID</label>
                <input type="number" class="form-control" id="student_id" name="student_id" required>
            </div>
            <div class="form-group">
                <label for="book_id">Book ID</label>
                <input type="number" class="form-control" id="book_id" name="book_id" required>
            </div>
            <div class="form-group">
                <label for="borrow_date">Borrow Date</label>
                <input type="date" class="form-control" id="borrow_date" name="borrow_date" required>
            </div>
            <div class="form-group">
                <label for="due_date">Due Date</label>
                <input type="date" class="form-control" id="due_date" name="due_date" required>
            </div>
            <button type="submit" class="btn btn-success">Borrow Book</button>
        </form>
    </div>
</body>
</html>

<?php $conn->close(); ?>
