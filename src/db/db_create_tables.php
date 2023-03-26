<?php

// Create Students & Courses table
function createTables($conn){
    $sql = getSQLForTables();
    
    $result = $conn->multi_query($sql);
    
    // Needed to allow multiquery function
    while($conn->next_result()) continue;

    if ($result) {
        echo "Tables created successfully\n";
      } 
    else {
        echo "Error creating table: " . $conn->error;
      }
}

function getSQLForTables(){
    $sql = "DROP TABLE IF EXISTS `Course_Table`;";
    $sql .= "DROP TABLE IF EXISTS `Name_Table`;";
    $sql .= 
    "
    CREATE TABLE `Name_Table` (
        `Student_ID` int(9) NOT NULL,
        `Student_Name` varchar(255) NOT NULL,
        PRIMARY KEY (`Student_ID`)
    );
    ";
    $sql .= 
    "
    CREATE TABLE `Course_Table` (
        `Student_ID` int(9) NOT NULL,
        `Course_Code` varchar(255) NOT NULL,
        `Test_1` decimal(3,1) NOT NULL,
        `Test_2` decimal(3,1) NOT NULL,
        `Test_3` decimal(3,1) NOT NULL,
        `Final_Exam` decimal(3,1) NOT NULL,
        PRIMARY KEY (`Student_ID`, `Course_Code`),
        FOREIGN KEY (`Student_ID`) REFERENCES `Name_Table`(`Student_ID`)
    );
    ";

    return $sql;
}
?>