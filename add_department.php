<?php
// Include database connection
include 'includes/db.php';

// Define variables and initialize with empty values
$department_name = $hod = "";
$department_name_err = $hod_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate department name
    if (empty(trim($_POST["department_name"]))) {
        $department_name_err = "Please enter department name.";
    } else {
        $department_name = trim($_POST["department_name"]);
    }

    // Validate HOD
    if (empty(trim($_POST["hod"]))) {
        $hod_err = "Please enter HOD name.";
    } else {
        $hod = trim($_POST["hod"]);
    }

    // Check input errors before inserting into database
    if (empty($department_name_err) && empty($hod_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO Department (Department_Name, HOD) VALUES (?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ss", $param_department_name, $param_hod);

            // Set parameters
            $param_department_name = $department_name;
            $param_hod = $hod;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to departments.php upon successful creation
                header("location: departments.php");
                exit();
            } else {
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Close connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Department</title>
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
            <h2>Add Department</h2>
            <p>Please fill this form to add a new department.</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group <?php echo (!empty($department_name_err)) ? 'has-error' : ''; ?>">
                    <label>Department Name</label>
                    <input type="text" name="department_name" class="form-control" value="<?php echo $department_name; ?>">
                    <span class="help-block"><?php echo $department_name_err; ?></span>
                </div>
                <div class="form-group <?php echo (!empty($hod_err)) ? 'has-error' : ''; ?>">
                    <label>HOD Name</label>
                    <input type="text" name="hod" class="form-control" value="<?php echo $hod; ?>">
                    <span class="help-block"><?php echo $hod_err; ?></span>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Submit">
                    <a href="departments.php" class="btn btn-default">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
