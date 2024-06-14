<?php
include 'includes/db.php';

$sql = "SELECT * FROM Library";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Books</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Library Books</h1>
        <a href="index.php" class="btn btn-primary mb-3">Back to Home</a>
        <a href="add_book.php" class="btn btn-success mb-3">Add Book</a>

        <?php
        if ($result->num_rows > 0) {
            echo '<table class="table table-striped">';
            echo '<thead><tr><th>ID</th><th>Title</th><th>Author</th><th>Quantity</th><th>Actions</th></tr></thead><tbody>';
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>{$row['Book_ID']}</td><td>{$row['Title']}</td><td>{$row['Author']}</td><td>{$row['Quantity']}</td>";
                echo "<td><a href='edit_book.php?id={$row['Book_ID']}' class='btn btn-warning btn-sm'>Edit</a> ";
                echo "<a href='delete_book.php?id={$row['Book_ID']}' class='btn btn-danger btn-sm'>Delete</a></td></tr>";
            }
            echo '</tbody></table>';
        } else {
            echo "<p>No books found in the library.</p>";
        }
        ?>

    </div>
</body>
</html>

<?php $conn->close(); ?>
