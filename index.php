<!DOCTYPE html>
<html>
<head>
    <title>Student Details Form</title>
    <style>
    .container{
      position: absolute;
      top:50%;
      left: 50%;
      transform: translate(-50%,-50%);
      width:40%;
      justify-content: center;
      padding:5px 8px 10px 8px;
      box-shadow: rgba(0,0,0,.35) 15px 15px 15px;
      background-color:lightslategrey;
    }
    </style>
</head>
<body>



<form   class="container" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<h2>Student Details</h2>
    Student Name: <input type="text" name="student_name"><br><br>
    Roll Number: <input type="text" name="roll_number"><br><br>
    Date of Birth: <input type="date" name="dob"><br><br>

    <h3>Subjects and Marks:</h3>
    <?php
    for ($i = 1; $i <= 5; $i++) {
        echo "Subject $i: <input type='text' name='subject_$i'> ";
        echo "Marks $i: <input type='text' name='marks_$i'><br><br>";
    }
    ?>

    <input type="submit" value="Submit">
</form>

<?php
include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $student_name = $_POST['student_name'];
    $roll_number = $_POST['roll_number'];
    $dob = $_POST['dob'];

    if(empty($student_name) && empty($roll_number) && empty($dob)) {
     echo '<h2> Dear Student Enter the details</h2>';
    }else{
        $dobb = date('Y-m-d', strtotime($dob));

    $today = new DateTime();
    $dob = new DateTime($dob);
    $age = $today->diff($dob)->y;

    $total_marks = 0;
    $subject_count = 5;
    for ($i = 1; $i <= $subject_count; $i++) {
        $subject = $_POST["subject_$i"];
        $marks = $_POST["marks_$i"];
        $total_marks += $marks;
    }
    $average_marks = $total_marks / $subject_count;

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "studentform";
    if ($conn=true) {
    echo"";
    }else{
        echo"NOT Connected";
    }

    $sql = "INSERT INTO formstd (student_name, roll_number, dob, age, total_marks, average_marks)
            VALUES ('$student_name', '$roll_number', '$dobb', '$age', '$total_marks', '$average_marks')";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if($conn->query($sql) === TRUE) {
        echo "<h3>Record inserted successfully</h3>";
            $sql = "SELECT * FROM formstd ORDER BY id DESC LIMIT 1";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo "<h2>Student Details</h2>";
                echo "Student Name: " . $row['student_name'] . "<br>";
                echo "Roll Number: " . $row['roll_number'] . "<br>";
                echo "Date of Birth: " . $row['dob'] . "<br>";
                echo "Age: " . $row['age'] . "<br>";
                echo "Total Marks: " . $row['total_marks'] . "<br>";
                echo "Average Marks: " . $row['average_marks'] . "<br>";
            } else {
                echo "No records found";
            }

            $conn->close();

    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    }

    
}
?>

</body>
</html>
