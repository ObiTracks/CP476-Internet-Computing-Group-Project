<?php
include 'db_connection.php';

// Prepare and execute SELECT statement
$select_stmt = $conn->prepare("SELECT * FROM NameTable INNER JOIN CourseTable ON NameTable.ID = CourseTable.ID WHERE NameTable.ID = ?");
$select_stmt->bind_param("i", $student_id);
$student_id = 1; // Replace with the desired student ID
$select_stmt->execute();
$select_result = $select_stmt->get_result();

// Process SELECT result
while ($row = $select_result->fetch_assoc()) {
    echo "Name: " . $row["FirstName"] . " " . $row["LastName"] . " - Course: " . $row["Course"] . " - Score: " . $row["Score"] . "<br>";
}

// Prepare and execute UPDATE statement
$update_stmt = $conn->prepare("UPDATE CourseTable SET Score = ? WHERE ID = ? AND Course = ?");
$update_stmt->bind_param("dis", $new_score, $student_id, $course);
$new_score = 80; // Replace with the desired new score
$course = "Math"; // Replace with the desired course
$update_stmt->execute();

// Close the connection
$conn->close();

?>