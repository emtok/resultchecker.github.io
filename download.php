<?php
session_start();
require 'dompdf/autoload.inc.php'; // Ensure you have this file from the dompdf library

use Dompdf\Dompdf;

if (!isset($_SESSION['student'])) {
    header("Location: index.html");
    exit;
}

$student = $_SESSION['student'];

$conn = new mysqli('localhost', 'root', '', 'students_db');
$student_id = $student['id'];
$sql = "SELECT * FROM results WHERE student_id='$student_id'";
$results = $conn->query($sql);

// Start output buffering to capture HTML
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Results</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 8px; text-align: center; }
        h1 { text-align: center; }
    </style>
</head>
<body>
    <h1>Results for <?php echo $student['name']; ?></h1>
    <p>Class: <?php echo $student['class']; ?> | Level: <?php echo $student['level']; ?></p>
    <table>
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
</body>
</html>
<?php
$html = ob_get_clean(); // Capture and clean the output buffer

// Initialize Dompdf
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait'); // Set paper size
$dompdf->render();

// Output the generated PDF for download
$dompdf->stream("Results_" . $student['name'] . ".pdf", ["Attachment" => true]);

exit;
?>
