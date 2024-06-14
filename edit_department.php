<?php
include 'includes/db.php';

$department_name = $hod = "";
$department_name_err = $hod_err = "";

if (isset($_GET['id'])) {
    $dept_id = $_GET['id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty(trim($_POST["department_name"]))) {
            $department_name_err = "Please enter department name.";
        } else {
            $department_name = trim($_POST["department_name"]);
        }

        if (empty(trim($_POST["hod"]))) {
            $hod_err = "Please enter HOD name.";
        } else {
            $hod = trim($_POST["hod"]);
        }

        if (empty($department_name_err) && empty($hod_err)) {
            $sql = "UPDATE Department SET Department_Name=?, HOD=? WHERE Dept_ID=?";

            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("ssi", $department_name, $hod, $dept_id);

                if ($stmt->execute()) {
                    header("Location: departments.php");
                    exit();
                } else {
                    echo "Something went wrong. Please try again later.";
                }

                $stmt->close();
            }
        }
    } else {
        $sql = "SELECT * FROM Department WHERE Dept_ID=?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("i", $dept_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $department = $result->fetch_assoc();
                $department_name = $department['Department_Name'];
                $hod = $department['HOD'];
            } else {
                header("Location: departments.php");
                exit();
            }

            $stmt->close();
        } else {
            echo "Error: " . $conn->error;
        }
    }
} else {
    header("Location: departments.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Department</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Edit Department</h1>
        <a href="departments.php" class="btn btn-primary mb-3">Back to Departments</a>
        
        <form method="POST" action="edit_department.php?id=<?php echo $dept_id; ?>">
            <div class="form-group">
                <label for="department_name">Department Name</label>
                <input type="text" class="form-control <?php echo (!empty($department_name_err)) ? 'is-invalid' : ''; ?>" id="department_name" name="department_name" value="<?php echo htmlspecialchars($department_name); ?>">
                <div class="invalid-feedback"><?php echo $department_name_err; ?></div>
            </div>
            <div class="form-group">
                <label for="hod">HOD Name</label>
                <input type="text" class="form-control <?php echo (!empty($hod_err)) ? 'is-invalid' : ''; ?>" id="hod" name="hod" value="<?php echo htmlspecialchars($hod); ?>">
                <div class="invalid-feedback"><?php echo $hod_err; ?></div>
            </div>
            <button type="submit" class="btn btn-warning">Update Department</button>
        </form>
    </div>
</body>
</html>

<?php $conn->close(); ?>
