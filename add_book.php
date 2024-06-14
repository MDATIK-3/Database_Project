<?php
include 'includes/db.php';

$title = $author = $quantity = $available = "";
$title_err = $author_err = $quantity_err = "";

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

    // Check input errors before inserting into database
    if (empty($title_err) && empty($author_err) && empty($quantity_err)) {
        $sql = "INSERT INTO Library (Title, Author, Quantity, Available) VALUES (?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssii", $title, $author, $quantity, $quantity); // Available initially equals Quantity

            if ($stmt->execute()) {
                header("location: list_books.php");
                exit();
            } else {
                echo "Something went wrong. Please try again later.";
            }

            $stmt->close();
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book</title>
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
            <h2>Add Book</h2>
            <p>Please fill this form to add a new book to the library.</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group <?php echo (!empty($title_err)) ? 'has-error' : ''; ?>">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control" value="<?php echo $title; ?>">
                    <span class="help-block"><?php echo $title_err; ?></span>
                </div>
                <div class="form-group <?php echo (!empty($author_err)) ? 'has-error' : ''; ?>">
                    <label>Author</label>
                    <input type="text" name="author" class="form-control" value="<?php echo $author; ?>">
                    <span class="help-block"><?php echo $author_err; ?></span>
                </div>
                <div class="form-group <?php echo (!empty($quantity_err)) ? 'has-error' : ''; ?>">
                    <label>Quantity</label>
                    <input type="text" name="quantity" class="form-control" value="<?php echo $quantity; ?>">
                    <span class="help-block"><?php echo $quantity_err; ?></span>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Add Book">
                    <a href="list_books.php" class="btn btn-default">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
