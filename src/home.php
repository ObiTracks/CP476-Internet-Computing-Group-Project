<!DOCTYPE html>
<html>
<head>
	<title>Home Page</title>
  <script>
    function updateStudent(event, rowData) {
      event.preventDefault();

      const row = JSON.parse(rowData);
      const form = document.createElement("form");
      form.method = "POST";
      form.action = "update.php";
      form.style.display = "none";
      
      for (const key in row) {
        const input = document.createElement("input");
        input.type = "hidden";
        input.name = key;
        input.value = row[key];
        form.appendChild(input);
      }

      document.body.appendChild(form);
      form.submit();
    }
  </script>
</head>
<body>
	<h1>Student Database</h1>
	
	<!-- Search bar -->
	<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<label for="search">Search:</label>
		<input type="text" name="search" id="search">
		<input type="submit" name="submit" value="Submit">
	</form>
	
	<!-- Student table -->
	<table>
		<thead>
			<tr>
				<th>Student Name</th>
				<th>Course</th>
				<th>Test 1 Grade</th>
				<th>Test 2 Grade</th>
				<th>Final Grade</th>
				<th>Update</th>
				<th>Delete</th>
			</tr>
		</thead>
		<tbody>
      <?php
        // Connect to the MySQL database
        $conn = mysqli_connect("localhost", "username", "password", "database_name");
        if (!$conn) {
          die("Connection failed: " . mysqli_connect_error());
        }

        // Check if the search bar was used
        if (isset($_POST["submit"])) {
          $search = $_POST["search"];
          $query = "SELECT * FROM students WHERE student_name LIKE '%$search%'";
        } else {
          $query = "SELECT * FROM students";
        }

        // Execute the query and display the results in the table
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)) {
          echo "<tr>";
          echo "<td><input type='text' name='student_name' value='" . $row["student_name"] . "'></td>";
          echo "<td><input type='text' name='course' value='" . $row["course"] . "'></td>";
          echo "<td><input type='text' name='test_1_grade' value='" . $row["test_1_grade"] . "'></td>";
          echo "<td><input type='text' name='test_2_grade' value='" . $row["test_2_grade"] . "'></td>";
          echo "<td><input type='text' name='final_grade' value='" . $row["final_grade"] . "'></td>";
          echo "<td><button onclick='updateStudent(event, " . json_encode($row) . ")'>Update</button></td>";
          echo "<td><button>Delete</button></td>";
          echo "</tr>";
        }

        // Close the database connection
        mysqli_close($conn);
      ?>
		</tbody>
	</table>
</body>
</html>
