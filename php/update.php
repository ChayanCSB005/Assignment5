<?php

include 'db.php';

$roll = $_POST['roll_no'];
$name = trim($_POST['name']);
$marks = $_POST['marks'];

if ($name === '' || !is_numeric($marks) ||
    $marks < 0 || $marks > 100) {
    die("Invalid student details!");
}

$sql = "UPDATE rollno
        SET name = ?, marks = ?
        WHERE roll_no = ?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "sis",
    $name,
    $marks,
    $roll
);

if (mysqli_stmt_execute($stmt)) {
    echo "Student updated successfully!";
} else {
    echo "Update failed!";
}

?>