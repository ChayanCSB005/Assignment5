<?php

include 'db.php';

$roll = $_POST['roll_no'];
$name = $_POST['name'];
$gender = $_POST['gender'];
$dept = $_POST['department'];
$marks = $_POST['marks'];

$sql = "INSERT INTO rollno
        (roll_no, name, gender, department, marks)
        VALUES (?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "ssssi",
    $roll,
    $name,
    $gender,
    $dept,
    $marks
);

if (mysqli_stmt_execute($stmt)) {
    echo "Student added successfully!";
} else {
    echo "Error: " . mysqli_stmt_error($stmt);
}

?>