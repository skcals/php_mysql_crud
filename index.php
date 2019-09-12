<?php
include "includes/header.php";
include "config/database.php";

$sql = "SELECT * FROM employees";

$res  = mysqli_query($conn, $sql);
?>

<div class="page-header d-flex justify-content-between">
    <div class="mb-2">
        <h2 class="pull-left">Employees Details</h2>
    </div>
    <div class="mb-2">
        <a href="create.php" class="btn btn-success">Add New Employee</a>
    </div>
</div>

<?php if (mysqli_num_rows($res) > 0) { ?>
    <table class="table table-bordered mt-4 ">
        <thead>
            <tr>
                <td>#</td>
                <td>Name</td>
                <td>Address</td>
                <td>Salary</td>
                <td>Action</td>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_array($res)) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['address']; ?></td>
                    <td><?php echo $row['salary']; ?></td>
                    <td class="d-flex justify-content-around">
                        <a href="read.php?id=<?php echo $row['id']; ?>">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a href="edit.php?id=<?php echo $row['id']; ?>">
                            <i class="fa fa-pencil-square-o"></i>
                        </a>
                        <a href="delete.php?id=<?php echo $row['id']; ?>">
                            <i class="fa fa-trash-o"></i>
                        </a>
                    </td>
                </tr>
            <?php }  ?>
        </tbody>
    </table>
<?php } else {  ?>
    <hr>
    <h4 class="text-muted">No data found...</h4>
<?php } ?>
<?php include "includes/footer.php"; ?>