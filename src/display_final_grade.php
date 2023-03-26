<?php
include 'db_connection.php';

function calculate_final_grade($scores) {
    // Replace with your own grading logic
    return array_sum($scores) / count($scores);
}

// Prepare and execute SELECT statement to get all scores for a student
$select_stmt = $conn->prepare("SELECT Score FROM CourseTable WHERE ID = ?");
$select_stmt->bind_param("i", $student_id);
$student_id = 1; // Replace with the desired student ID
$select_stmt->execute();
$select_result = $select_stmt->get_result();

// Process SELECT result and calculate the final grade
$scores = [];
while ($row = $select_result->fetch_assoc()) {
    $scores[] = $row["Score"];
}

$final_grade = calculate_final_grade($scores);
echo "Final Grade: " . $final_grade;

// Close the connection
$conn->close();

?>