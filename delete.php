<?php

include "includes/header.php";
include "config/database.php";


if (isset($_POST['id']) && !empty(trim($_POST['id']))) {
    $sql = "DELETE FROM employees WHERE id = ?";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, 'i', $param_id);

        // Set Parameters
        $param_id = trim($_POST['id']);

        if (mysqli_stmt_execute($stmt)) {
            header("location:index.php");
            exit();
        } else {
            echo "Something went wrong, Please try again later";
        }
    }
    // Close statement 
    mysqli_stmt_close($stmt);
    // Close Connection 
    mysqli_close($conn);
} else {
    if (empty(trim($_GET['id']))) {
        header("location:error.php");
        exit();
    }
}

?>

<div class="header mb-4">
    <h2>Delete Record</h2>
</div>

<div class="alert alert-danger">
    <p>Are you sure want to delete this record?</p>
    <br>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <input type="hidden" name="id" value="<?php echo trim($_GET['id']); ?>">
        <input type="submit" value="Delete" class="btn btn-danger">
    </form>
    <a href="index.php" class="btn bg-dark text-white">Back</a>
</div>

<?php include "includes/footer.php"; ?>