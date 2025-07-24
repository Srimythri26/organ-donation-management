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
$stmt = $conn->prepare("INSERT INTO donor ( name, address, city, district, mobile_number, emergency_mobile, email, password, dob, age, death_status, gender, blood_group, identity_card, identity_number, medical_history, current_medications, organs_to_donate, donation_purpose, terms) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssssssssssssssss", $name, $address, $city, $district, $mobile_number, $emergency_mobile, $email, $password, $dob, $age, $death_status, $gender, $blood_group, $identity_card, $identity_number, $medical_history, $current_medications, $organs_to_donate, $donation_purpose, $terms);

// Set parameters and execute
$name = $_POST['name'];
$address = $_POST['address'];
$city = $_POST['city'];
$district = $_POST['district'];
$mobile_number = $_POST['mobile_number'];
$emergency_mobile = $_POST['emergency_mobile'];
$email = $_POST['email'];
$password = $_POST['password']; // Hashing the password
$dob = $_POST['dob'];
$age = $_POST['age'];
$death_status = $_POST['death_status'];
$gender = $_POST['gender'];
$blood_group = $_POST['blood_group'];
$identity_card = $_POST['identity_card'];
$identity_number = $_POST['identity_number'];
$medical_history = $_POST['medical_history'];
$current_medications = $_POST['current_medications'];
$organs_to_donate = implode(",", $_POST['organ']); // Convert array to string
$donation_purpose = $_POST['donation_purpose'];
$terms = isset($_POST['terms']) ? 1 : 0;

if ($stmt->execute()) {
    echo "New record created successfully";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>