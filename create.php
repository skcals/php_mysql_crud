<?php

include "includes/header.php";
include "config/database.php";

$name = $address = $salary = "";
$name_err = $address_err = $salary_err = "";


if ($_SERVER['REQUEST_METHOD'] == "POST") {

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
        $sql = "INSERT INTO employees (name, address, salary) VALUES (?, ?, ?)";


        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "sss", $param_name, $param_address, $param_salary);

            // Set Parameters
            $param_name = $name;
            $param_address = $address;
            $param_salary = $salary;

            // Execute the prepare statement
            if (mysqli_stmt_execute($stmt)) {
                header("location:index.php");
                exit();
            } else {
                echo "Something went wrong. Please try again later";
            }
        }
        // Close statement
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
}

?>

<div class="header mb-5">
    <h2>Create New Record</h2>
</div>


<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
        <span class="text-danger">
            <?php echo $name_err; ?>
        </span>
    </div>
    <div class="form-group has-warning">
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