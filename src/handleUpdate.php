<?php 
  require __DIR__ . '/db/db_connection.php'; 


  // Check if values were submitted and Send them to db
  if (isset($_POST["submitGrades"]) && sendGradeUpdatesToDB()) {
    echo "<h2>Grades Submitted Succesfully<h2>";
  } 

  function sendGradeUpdatesToDB(){
    $conn  = connectToDB("StudentGradesDB");

    // Data does not need to be validated due to restrictions placed on user input
    $test_1 = $_POST["Test_1"];
    $test_2 = $_POST["Test_2"];
    $test_3 = $_POST["Test_3"];
    $final_exam = $_POST["Final_Exam"];

    // Collect the Student ID that directed to this page
    $split = explode("_", $_POST["Edit"]);
    $student_id = $split[0];
    $course_code = $split[1];

    $sql = 
    "
    UPDATE StudentGradesDB.Course_Table AS Courses
    SET Courses.Test_1=" . $test_1 . 
    ", Courses.Test_2=" . $test_2 . 
    ", Courses.Test_3=" . $test_3 . 
    ", Courses.Final_Exam=" . $final_exam . 
    "
    WHERE Courses.Course_Code='" . $course_code . 
    "' AND Courses.Student_ID=" . $student_id;

    echo $sql;
    $result = mysqli_query($conn, $sql);

    $conn->close();

    return $result;
  }


?>


<!DOCTYPE html>
<html>
<head>
  <title>Update User Grades</title>
</head>
<body>
  <h3 class="heading"> Fill in the updated grades. </h3>
  

    
  <?php print_r($_POST);?>
  <form class="Home" method="POST" action="home.php">
		<input type="submit" name="Home" value="Home">
  </form>

	<form class="handleUpdate" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<label for="search">Test 1:</label>
		<input type="number" step="0.01" name="Test_1" max="99.9" min="0" required>
    <label for="search">Test 2:</label>
		<input type="number" step="0.01" name="Test_2" max="99.9" min="0" required>
    <label for="search">Test 3:</label>
		<input type="number" step="0.01" name="Test_3" max="99.9" min="0" required>
    <label for="search">Final_Exam:</label>
		<input type="number" step="0.01" name="Final_Exam" max="99.9" min="0" required>
    <input type="hidden" name="Edit" value="<?php echo $_POST["Edit"]; ?>">

		<input type="submit" name="submitGrades" value="Submit">
	</form>


</body>
</html>