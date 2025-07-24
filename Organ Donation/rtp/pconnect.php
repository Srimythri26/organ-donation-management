<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "organdonation";
$port = 3060;  // Specify the port number

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO patient ( name, address, city, district, mobile_number, emergency_mobile, email, password, dob, age, gender, blood_group, identity_card, identity_number, medical_history, current_medications, organ, time_required, terms) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssssssssssssssss", $name, $address, $city, $district, $mobile_number, $emergency_mobile, $email, $password, $dob, $age, $gender, $blood_group, $identity_card, $identity_number, $medical_history, $current_medications, $organ, $time_required, $terms);

// Set parameters and execute
$name = $_POST['name'];
$address = $_POST['address'];
$city = $_POST['city'];
$district = $_POST['district'];
$mobile_number = $_POST['mobile_number'];
$emergency_mobile = $_POST['emergency_mobile'];
$email = $_POST['email'];
$password = $_POST['password'];
$dob = $_POST['dob'];
$age = $_POST['age'];
$gender = $_POST['gender'];
$blood_group = $_POST['blood_group'];
$identity_card = $_POST['identity_card'];
$identity_number = $_POST['identity_number'];
$medical_history = $_POST['medical_history'];
$current_medications = $_POST['current_medications'];
$organ = implode(",", $_POST['organ']); // Convert array to string
$time_required = $_POST['time_required'];
$terms = isset($_POST['terms']) ? 1 : 0;

if ($stmt->execute()) {
    echo "New record created successfully";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>