<?php 
  require __DIR__ . '/db/db_connection.php'; 

  // Function to display table 
  // Called at start with null and submit when entering an id
  function displayTable() {
    $conn  = connectToDB("StudentGradesDB");

    // Check if the search bar was used
    // TODO: SANITIZE AND VALIDATE ID
    if (isset($_POST["submit"]) && array_key_exists("search", $_POST) && $_POST["search"] !== "") {
      $id = $_POST["search"];
    } else {
      $id = null;
    }

    $sql = getSQLForTableData($id);

    $result = mysqli_query($conn, $sql);

    // Check if there are any rows in the result set
    if (mysqli_num_rows($result) > 0) {
      // Build the table
      echo "<table>";
      echo "<tr><th>Student Name</th><th>Student ID</th><th>Course Code</th><th>Test 1</th><th>Test 2</th><th>Test 3</th><th>Final Exam</th><th>Final Grade</th><th></th><th></th></tr>";

      // Loop through each row in the result set and add it to the table
      while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<form class='handleUpdate' action='" . $_SERVER['PHP_SELF'] . "' method='POST'>";
        echo "<td>" . $row["Student_Name"] . "</td>";
        echo "<td>" . $row["Student_ID"] . "</td>";
        echo "<td>" . $row["Course_Code"] . "</td>";
        echo "<td><input type='number' step='0.1' name='Test_1' max='99.9' min='0' value='" . $row["Test_1"] . "' ></td>";
        echo "<td><input type='number' step='0.1' name='Test_2' max='99.9' min='0' value='" . $row["Test_2"] . "' ></td>";
        echo "<td><input type='number' step='0.1' name='Test_3' max='99.9' min='0' value='" . $row["Test_3"] . "' ></td>";
        echo "<td><input type='number' step='0.1' name='Final_Exam' max='99.9' min='0' value='" . $row["Final_Exam"] . "' ></td>";
        echo "<td>" . $row["Test_1"]/100*20 + $row["Test_2"]/100*20 + $row["Test_3"]/100*20 + $row["Final_Exam"]/100*40 . "</td>";
        echo "<td><input type='submit' name='Save' value='Save'></td>";
        echo "<td><input type='hidden' value='". $row["Student_ID"] . "' name='Student_ID'></td>";
        echo "<td><input type='hidden' value='". $row["Course_Code"] . "' name='Course_Code'></td>";

        echo "</form>";
        echo "</tr>";
      }

      // End the table 
      echo "</table>";
    } else {
      echo "No data found in table.";
    }

    $conn->close();
  }

  // Function to generate query statement for table data
  // If id is set then we will be adding a where clause to select only that students grades
  function getSQLForTableData($id=null){
    $sql = 
      "
      SELECT Students.Student_Name, Students.Student_ID, Courses.Course_Code, 
      Courses.Test_1, Courses.Test_2, Courses.Test_3, Courses.Final_Exam
      FROM StudentGradesDB.Course_Table AS Courses
      INNER JOIN StudentGradesDB.Name_Table AS Students
      ON Students.Student_ID=Courses.Student_ID 
      ";
  
    // TO DO: MAKE THIS A PREPARED STATEMENT
    if ($id !== null){
      $sql .=
      "
       WHERE Students.Student_ID=
      ";
      $sql .= $id;
    }

    return $sql;
  }


    // Check if values were submitted and Send them to db
    if (array_key_exists("Save", $_POST) && isset($_POST["Save"])) {
      sendGradeUpdatesToDB();
    } 
  
    function sendGradeUpdatesToDB(){
      $conn  = connectToDB("StudentGradesDB");
  
      // Data does not need to be validated due to restrictions placed on user input
      $test_1 = $_POST["Test_1"];
      $test_2 = $_POST["Test_2"];
      $test_3 = $_POST["Test_3"];
      $final_exam = $_POST["Final_Exam"];
      $student_id = $_POST["Student_ID"];
      $course_code = $_POST["Course_Code"];
  
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

<!doctype html>
<html>
  <head>
    <title>Grade Editor</title>
    <style>
      table {
        border-collapse: collapse;
        width: 100%;
      }

      th, td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
      }

      th {
        background-color: #f2f2f2;
      }
	  </style>
  </head>

  <body>
    <h3 class="heading"> Please type a student ID to see their grades: </h3>
  
  <!-- Search bar -->
	<form class="handleUserSearch" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<label for="search">Search:</label>
		<input type="text" name="search" id="search">
		<input type="submit" name="submit" value="Submit">
	</form>

  <!--<form class='handleUpdate' action='<?php echo $_SERVER['PHP_SELF']; ?>' method='POST'> -->
    <?php 
    print_r($_POST);
    displayTable(); 
    ?>
  <!-- </form> -->



  </body>
</html>


