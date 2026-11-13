<?php

include 'db.php';

$search = $_GET['search'] ?? '';

$sql = "SELECT * FROM rollno
        WHERE roll_no LIKE ?
        OR name LIKE ?
        OR department LIKE ?
        OR gender LIKE ?";

$stmt = mysqli_prepare($conn, $sql);

$value = "%" . $search . "%";

mysqli_stmt_bind_param(
    $stmt,
    "ssss",
    $value,
    $value,
    $value,
    $value
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$students = [];

while ($row = mysqli_fetch_assoc($result)) {
    $students[] = $row;
}

header('Content-Type: application/json');

echo json_encode($students);

?>