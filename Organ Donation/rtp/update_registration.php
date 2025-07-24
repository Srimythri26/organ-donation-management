<?php
session_start();
include 'db_connection.php';

// Check if the user is logged in
if (!isset($_SESSION['donor_id'])) {
    header("Location: dlog.html");
    exit();
}

// Get the donor ID from the session
$donor_id = $_SESSION['donor_id'];

// Fetch form data
$name = $_POST['name'];
$address = $_POST['address'];
$city = $_POST['city'];
$district = $_POST['district'];
$dob = $_POST['dob'];
$age = $_POST['age'];
$gender = $_POST['gender'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$password = $_POST['password'];
$weight = $_POST['weight'];
$bloodgroup = $_POST['bloodgroup'];
$diseases = $_POST['diseases'];

// Update the donor's data in the database
$sql = $conn->prepare("UPDATE donors SET name=?, address=?, city=?, district=?, dob=?, age=?, gender=?, email=?, phone=?, password=?, weight=?, bloodgroup=?, diseases=? WHERE donor_id=?");
$sql->bind_param("sssssisisssissi", $name, $address, $city, $district, $dob, $age, $gender, $email, $phone, $password, $weight, $bloodgroup, $diseases, $donor_id);

if ($sql->execute()) {
    echo "Donor information updated successfully.";
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();
?>
