<?php

include 'db.php';

$sql = "SELECT * FROM rollno";

$result = mysqli_query($conn, $sql);

$students = [];

while ($row = mysqli_fetch_assoc($result)) {
    $students[] = $row;
}

header('Content-Type: application/json');

echo json_encode($students);

?>