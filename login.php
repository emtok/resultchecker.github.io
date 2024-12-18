<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'students_db');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $exam_number = $_POST['exam_number'];

    $sql = "SELECT * FROM students WHERE email='$email' AND exam_number='$exam_number'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
        $_SESSION['student'] = $student;

        header("Location: results.php");
    } else {
        echo "<p>Invalid login credentials.</p>";
    }
}
?>
