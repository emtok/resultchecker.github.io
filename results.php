<?php
session_start();
if (!isset($_SESSION['student'])) {
    header("Location: index.html");
    exit;
}

$student = $_SESSION['student'];

$conn = new mysqli('localhost', 'root', '', 'students_db');
$student_id = $student['id'];
$sql = "SELECT * FROM results WHERE student_id='$student_id'";
$results = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Results</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
   <div class="login-container">	
    <h1>Results for <?php echo $student['name']; ?></h1>
    <p>Name:<?php echo $student['name']; ?> <br> Class: <?php echo $student['class']; ?> | Level: <?php echo $student['level']; ?></p>
    <table border="1">
        <tr>
            <th>Course Code</th>
            <th>Course Name</th>
            <th>Grade</th>
        </tr>
        <?php while ($row = $results->fetch_assoc()) : ?>
        <tr>
            <td><?php echo $row['course_code']; ?></td>
            <td><?php echo $row['course_name']; ?></td>
            <td><?php echo $row['grade']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
  
    <form action="download.php" method="POST">
        <button type="submit">Download PDF</button>
    </form>
 </div>
</body>
</html>
