<?php
$name = $_POST['name'];
$email = $_POST['email'];
$student_id = $_POST['student_id'];
$faculty = $_POST['faculty'];
$message = $_POST['message'];

$conn = new mysqli('localhost', 'root', '', 'commentbox');

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
} else {
    $stmt = $conn->prepare("INSERT INTO commentbox (name, email, student_id, faculty, msg) VALUES (?, ?, ?, ?, ?)");
    // Binding parameters
    $stmt->bind_param('sssss', $name, $email, $student_id, $faculty,$message);
    // Executing the statement
    $execval = $stmt->execute();
    if ($execval) {
        header('Location: commentBox.html');
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
}
?>
