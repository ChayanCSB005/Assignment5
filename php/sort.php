<?php

include 'db.php';

$allowed = [
    "roll_no",
    "name",
    "gender",
    "department",
    "marks"
];

$column = $_GET['column'] ?? 'roll_no';

$order = $_GET['order'] ?? 'ASC';

if (!in_array($column, $allowed)) {
    $column = 'roll_no';
}

if ($order !== 'ASC' && $order !== 'DESC') {
    $order = 'ASC';
}

$sql = "SELECT * FROM rollno
        ORDER BY $column $order";

$result = mysqli_query($conn, $sql);

$students = [];

while ($row = mysqli_fetch_assoc($result)) {
    $students[] = $row;
}

header('Content-Type: application/json');

echo json_encode($students);

?>