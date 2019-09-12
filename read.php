<?php
include 'includes/header.php';
// Check existence of id parameter before processing further

if (isset($_GET['id']) && !empty(trim($_GET['id']))) {
    include "config/database.php";

    // Prepare a select statement;

    $sql = "SELECT * FROM employees WHERE id = ? ";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, 's', $param_id);

        $param_id = trim($_GET['id']);

        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                extract($row);
            } else {
                header("location:error.php");
                exit();
            }
        } else {
            echo "Oops! Something went wrong. Please try again later";
        }
    }
    // close statement
    mysqli_stmt_close($stmt);
    // close connection
    mysqli_close($conn);
} else {
    // URL dosen't contain id parameter. Redirect to error page
    header("location:error.php");
    exit();
}
?>

<div class="header mb-4">
    <h2>View Record</h2>
</div>

<h5>Name</h5>
<p><?php echo $name; ?></p>
<hr>

<h5>Address</h5>
<p><?php echo nl2br($address); ?></p>
<hr>

<h5>Salary</h5>
<p><?php echo $salary; ?></p>
<hr>

<a href="index.php" class="btn bg-dark text-white">Back</a>


<?php include "includes/footer.php"; ?>