<?php

include 'db.php';

$roll = $_POST['roll_no'];

$sql = "DELETE FROM rollno WHERE roll_no = ?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "s", $roll);

if (mysqli_stmt_execute($stmt)) {
    echo "Student deleted successfully!";
} else {
    echo "Delete failed!";
}

?>