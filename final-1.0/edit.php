<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit;
}

include 'connect.php';

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM results WHERE id = '$id'");
$data = mysqli_fetch_assoc($result);

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $index_number = $_POST['index_number'];
    $course_code = $_POST['course_code'];
    $course_name = $_POST['course_name'];
    $grade = $_POST['grade'];

    $update = "UPDATE results SET 
        index_number = '$index_number',
        course_code = '$course_code',
        course_name = '$course_name',
        grade = '$grade'
        WHERE id = '$id'";
    mysqli_query($conn, $update);

    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Result</title>
</head>

<body>
    <h2>Edit Student Result</h2>
    <form method="POST">
        <input type="text" name="index_number" value="<?= htmlspecialchars($data['index_number']) ?>" required>
        <input type="text" name="course_code" value="<?= htmlspecialchars($data['course_code']) ?>" required>
        <input type="text" name="course_name" value="<?= htmlspecialchars($data['course_name']) ?>" required>
        <input type="text" name="grade" value="<?= htmlspecialchars($data['grade']) ?>" required>
        <button type="submit">Update</button>
    </form>
</body>

</html>