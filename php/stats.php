<?php

include 'db.php';

$result = mysqli_query($conn, "SELECT * FROM rollno");

$marks_array = [];
$students = [];

while ($row = mysqli_fetch_assoc($result)) {

    $marks = (int)$row['marks'];

    $marks_array[] = $marks;

    if ($marks > 80) {
        $grade = "A";
    }
    elseif ($marks > 60) {
        $grade = "B";
    }
    else {
        $grade = "C";
    }

    $row['grade'] = $grade;

    $students[] = $row;
}

$total = array_sum($marks_array);

$count = count($marks_array);

$average = $count > 0 ? $total / $count : 0;

header('Content-Type: application/json');

echo json_encode([
    "total" => $total,
    "average" => round($average, 2),
    "students" => $students
]);

?>