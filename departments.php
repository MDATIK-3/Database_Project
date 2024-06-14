<?php
include 'includes/db.php';

$department_name_err = $hod_err = "";
$department_name = $hod = "";

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
        $sql = "INSERT INTO Department (Department_Name, HOD) VALUES (?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ss", $param_department_name, $param_hod);

            $param_department_name = $department_name;
            $param_hod = $hod;

            if ($stmt->execute()) {
                header("location: departments.php");
                exit();
            } else {
                echo "Something went wrong. Please try again later.";
            }

            $stmt->close();
        }
    }
}

function sanitize_input($data)
{
    $data = trim($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Departments</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container">
        <h1 class="mt-5">Departments</h1>
        <a href="index.php" class="btn btn-primary mb-3">Back to Home</a>
        <a href="add_department.php" class="btn btn-success mb-3">Add Department</a>

        <?php
        $sql = "SELECT * FROM Department";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<table class="table table-striped">';
            echo '<thead><tr><th>ID</th><th>Name</th><th>HOD</th><th>Actions</th></tr></thead><tbody>';
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>{$row['Dept_ID']}</td><td>{$row['Department_Name']}</td><td>{$row['HOD']}</td>";
                echo "<td><a href='edit_department.php?id={$row['Dept_ID']}' class='btn btn-warning btn-sm'>Edit</a> ";
                echo "<a href='delete_department.php?id={$row['Dept_ID']}' class='btn btn-danger btn-sm'>Delete</a></td></tr>";
            }
            echo '</tbody></table>';
        } else {
            echo "<p>No departments found.</p>";
        }
        ?>
    </div>
  <!-- Add Department Modal -->
  <div class="modal fade" id="addDepartmentModal" tabindex="-1" role="dialog"
        aria-labelledby="addDepartmentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDepartmentModalLabel">Add Department</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label for="department_name">Department Name</label>
                            <input type="text"
                                class="form-control <?php echo (!empty($department_name_err)) ? 'is-invalid' : ''; ?>"
                                id="department_name" name="department_name" value="<?php echo $department_name; ?>">
                            <span class="invalid-feedback"><?php echo $department_name_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label for="hod">HOD Name</label>
                            <input type="text"
                                class="form-control <?php echo (!empty($hod_err)) ? 'is-invalid' : ''; ?>" id="hod"
                                name="hod" value="<?php echo $hod; ?>">
                            <span class="invalid-feedback"><?php echo $hod_err; ?></span>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Department</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
  

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>

<?php $conn->close(); ?>