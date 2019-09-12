<?php

include "config/database.php";
include "includes/header.php";

$name = $address = $salary = "";
$name_err = $address_err = $salary_err = "";


if (isset($_POST['id']) && !empty(trim($_POST['id']))) {

    $id = $_POST['id'];

    // Validate Name
    $input_name = trim($_POST["name"]);
    if (empty($input_name)) {
        $name_err = "Please enter a name.";
    } elseif (!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $name_err = "Please enter a valid name ...";
    } else {
        $name = $input_name;
    }

    // Validate Address
    $input_address = trim($_POST['address']);
    if (empty($input_address)) {
        $address_err = "Please enter an address.";
    } else {
        $address = $input_address;
    }

    // Validate Salary
    $input_salary = trim($_POST['salary']);
    if (empty($input_salary)) {
        $salary_err = "Please enter the salary amount.";
    } elseif (!ctype_digit($input_salary)) {
        $salary_err = "Please enter a positive integer value";
    } else {
        $salary = $input_salary;
    }


    // Check input errors before inserting in database
    if (empty($name_err) && empty($address_err) && empty($salary_err)) {
        // Prepare an insert statement
        $sql = "UPDATE employees SET name = ? , address=?, salary=? WHERE id = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, 'sssi', $param_name, $param_address, $param_salary, $param_id);

            // Set Parameters

            $param_name = $name;
            $param_address = $address;
            $param_salary = $salary;
            $param_id = $id;

            if (mysqli_stmt_execute($stmt)) {
                header("location:index.php");
                exit();
            } else {
                echo "Something went wrong please try again later...";
            }
        }
        // Close statement
        mysqli_stmt_close($stmt);
    }
    // Close Connection
    mysqli_close($conn);
} else {
    if (isset($_GET['id']) && !empty(trim($_GET['id']))) {
        $id = trim($_GET['id']);

        $sql = "SELECT * FROM employees WHERE id = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, 'i', $param_id);

            // Set Parameter
            $param_id = $id;

            if (mysqli_stmt_execute($stmt)) {
                $res = mysqli_stmt_get_result($stmt);
                if (mysqli_num_rows($res) == 1) {
                    $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
                    extract($row);
                } else {
                    header("location:error.php");
                    exit();
                }
            } else {
                echo "Something went wrong, Please try again later...";
            }
            // Close statement
            mysqli_stmt_close($stmt);
        }

        // Close connection
        mysqli_close($conn);
    } else {
        // URL dosen't contain id parameter, Redirect to error page
        header("location:error.php");
        exit();
    }
}

?>



<div class="header">
    <h2>Update Record</h2>
</div>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
        <span class="text-danger">
            <?php echo $name_err; ?>
        </span>
    </div>
    <div class="form-group">
        <label for="address">Address</label>
        <textarea name="address" class="form-control" rows=4><?php echo $address; ?></textarea>
        <span class="text-danger">
            <?php echo $address_err; ?>
        </span>
    </div>
    <div class="form-group">
        <label for="salary">Salary</label>
        <input type="text" name="salary" class="form-control" value="<?php echo $salary; ?>">
        <span class="text-danger">
            <?php echo $salary_err; ?>
        </span>
    </div>
    <div class="form-group mt-4">
        <input type="submit" value="Submit" class="btn btn-primary">
        <a href="index.php" class="btn bg-dark text-white">Cancel</a>
    </div>

</form>
<?php include "includes/footer.php"; ?>