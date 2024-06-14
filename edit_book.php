<?php
include 'includes/db.php';

$book_id = $title = $author = $quantity = "";

if (isset($_GET['id']) && !empty(trim($_GET['id']))) {
    $book_id = trim($_GET['id']);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate title
        if (empty(trim($_POST["title"]))) {
            $title_err = "Please enter the title of the book.";
        } else {
            $title = trim($_POST["title"]);
        }

        // Validate author
        if (empty(trim($_POST["author"]))) {
            $author_err = "Please enter the author of the book.";
        } else {
            $author = trim($_POST["author"]);
        }

        // Validate quantity
        if (empty(trim($_POST["quantity"]))) {
            $quantity_err = "Please enter the quantity of the book.";
        } elseif (!ctype_digit(trim($_POST["quantity"]))) {
            $quantity_err = "Quantity must be a positive integer.";
        } else {
            $quantity = trim($_POST["quantity"]);
        }

        // Check input errors before updating the database
        if (empty($title_err) && empty($author_err) && empty($quantity_err)) {
            $sql = "UPDATE Library SET Title=?, Author=?, Quantity=? WHERE Book_ID=?";

            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("ssii", $title, $author, $quantity, $book_id);

                if ($stmt->execute()) {
                    header("location: list_books.php");
                    exit();
                } else {
                    echo "Something went wrong. Please try again later.";
                }

                $stmt->close();
            }
        }
    } else {
        $sql = "SELECT * FROM Library WHERE Book_ID = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("i", $param_book_id);
            $param_book_id = $book_id;

            if ($stmt->execute()) {
                $result = $stmt->get_result();
                if ($result->num_rows == 1) {
                    $row = $result->fetch_array(MYSQLI_ASSOC);
                    $title = $row['Title'];
                    $author = $row['Author'];
                    $quantity = $row['Quantity'];
                } else {
                    header("location: list_books.php");
                    exit();
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            $stmt->close();
        }
    }

    $conn->close();
} else {
    header("location: list_books.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        .wrapper {
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="mt-5">
            <h2>Edit Book</h2>
            <p>Please fill this form to edit the book.</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $book_id; ?>" method="post">
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control" value="<?php echo $title; ?>">
                </div>
                <div class="form-group">
                    <label>Author</label>
                    <input type="text" name="author" class="form-control" value="<?php echo $author; ?>">
                </div>
                <div class="form-group">
                    <label>Quantity</label>
                    <input type="text" name="quantity" class="form-control" value="<?php echo $quantity; ?>">
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Update Book">
                    <a href="list_books.php" class="btn btn-default">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
