<?php
session_start();
include 'db_connection.php';

$email = $_POST['email'];
$password = $_POST['password'];

// Use prepared statements to prevent SQL injection
$sql = $conn->prepare("SELECT * FROM donor WHERE email = ?");
$sql->bind_param("s", $email);
$sql->execute();
$result = $sql->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Verify password (plain text comparison)
    if ($password === $row['password']) {
        $_SESSION['donor_id'] = $row['donor_id'];
        header("Location: dupdate.html");
        exit(); // Ensure the script stops after redirect
    } else {
        echo "Invalid password.";
    }
} else {
    echo "Invalid email.";
}

$conn->close();
?>
