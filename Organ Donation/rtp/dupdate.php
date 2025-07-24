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

// Fetch the donor's data from the database
$sql = $conn->prepare("SELECT * FROM donors WHERE donor_id = ?");
$sql->bind_param("i", $donor_id);
$sql->execute();
$result = $sql->get_result();

// Check if the donor exists
if ($result->num_rows > 0) {
    $donor = $result->fetch_assoc();
} else {
    echo "No donor found.";
    exit();
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Donor Update Form</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.1/css/fontawesome.min.css" 
  integrity="sha384-QYIZto+st3yW+o8+5OHfT6S482Zsvz2WfOzpFSXMF9zqeLcFV0/wlZpMtyFcZALm" 
  crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">
  <style>
/* Navbar Styles */
body{
    background-color: #edefef ;
    margin-top: 0;
    margin-left: 0;
    margin-right: 0;
}
.navbar {
  background-color: #4ba7a7;
  border-radius: 0;
  margin-bottom: 20px;
}

.navbar ul {
  overflow: auto;
  text-align: center;
  padding: 0;
  margin: 0;
  overflow: hidden;
  transition: 1s;
}

.navbar li {
  display: inline-block;
  list-style: none;
  margin: 12px 12px;
}

.navbar li a {
    padding: 10px 20px; /* Adjust padding for top/bottom and left/right */
    text-decoration: none;
    font-size: 17px;
    font-weight: 700;
    color: white;
    display: inline-block; /* Ensure items are displayed as blocks */
    border-radius: 5px; /* Add border-radius for rounded corners */
    background-color: #4ba7a7; /* Change background color */
    margin: 0 10px; /* Adjust margin between items */
}

.navbar li a:hover,
.navbar li a.active {
    background-color: #1f2151; /* Change background color on hover/active */
}
.container {
      display: flex;
      width: 100%;
    }

    .image-section {
      width: 40%;
      padding: 20px;
    }

    .image-section img {
      max-width: 650px;
      border-radius: 0;
      margin-bottom: 20px;
      padding-top: 0%;
    }

    .form-section {
      width: 50%;
      padding: 20px;
      margin-left: 25px;
    }

    .form-group {
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .form-group label {
      margin-top: 10px;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    fieldset {
      margin-bottom: 20px;
      padding: 20px;
      border: 2px solid #ccc;
      border-radius: 4px;
    }

    legend {
      font-size: 18px;
      font-weight: bold;
    }

    .checkbox-wrapper {
      display: flex;
      align-items: center;
    }

    .checkbox-wrapper input {
      margin-right: 10px;
    }

    .input-container {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      align-items: center;
    }

    .input-container label {
      flex: 1;
    }

    .input-container input,
    .input-container select,
    .input-container textarea {
      flex: 2;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    button {
      padding: 10px 20px;
      background-color: #4ba7a7;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 16px;
      margin-bottom: 10px;
    }

    button:hover {
      background-color: #1f2151;
    }

    .image1 {
      width: 150%;
      height: auto;
    }

    .image2 {
      width: 80%;
      height: auto;
    }

    .image3 {
      width: 90%;
      height: auto;
    }

    .image4 {
      width: 70%;
      height: auto;
    }

    .image5 {
      width: 100%;
      height: auto;
    }
    .form-group input[type="password"] {
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
</style>
<script>
    function calculateAge() {
      const dob = document.getElementById('dob').value;
      const dobDate = new Date(dob);
      const today = new Date();
      let age = today.getFullYear() - dobDate.getFullYear();
      const monthDifference = today.getMonth() - dobDate.getMonth();
      if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < dobDate.getDate())) {
        age--;
      }
      document.getElementById('age').value = age;
    }
    function handleLogout() {
      window.location.href = 'donor.html';
    }
  </script>
</head>

<body>
  <header class="navbar">
    <ul>
      <li><a href="./Home.html"><i class="fa-duotone fa-memo-pad"></i>HOME</a></li>
      <li><a href="./user.html"><i class="fa-duotone fa-memo-pad"></i>PATIENT</a></li>
      <li><a href="donor.html" class="active">DONOR</a></li> 
      <li><a href="./admin.html"><i class="fa-duotone fa-memo-pad"></i>ADMIN</a></li>
      <li><a href="./FAQ.html"><i class="fa-duotone fa-memo-pad"></i>FAQ'S</a></li>
      <li><a href="./contact us.html"><i class="class="fa-duotone fa-memo-pad"></i>CONTACT US</a></li>
    </ul>
  </header> 
  <div class="container">
    <div class="form-section">
      <h2>Update Donor Registration Information</h2>
      <form action="update_registration.php" method="POST">
        <fieldset>
          <legend>1. Personal Information</legend>
          <div class="form-group">
            <div class="input-container">
              <label for="name">Name:</label>
              <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>" required>
            </div>
            <div class="input-container">
              <label for="address">Address:</label>
              <textarea id="address" name="address" rows="4" required><?php echo ($donor['address']); ?></textarea>
            </div>
            <div class="input-container">
              <label for="city">City:</label>
              <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($donor['city']); ?>" required>
            </div>
            <div class="input-container">
              <label for="district">District:</label>
              <select id="district" name="district" required>
                <option value="">Select District</option>
                <option value="Adilabad" <?php if ($donor['district'] == 'Adilabad') echo 'selected'; ?>>Adilabad</option>
                <option value="Bhadradri Kothagudem" <?php if ($donor['district'] == 'Bhadradri Kothagudem') echo 'selected'; ?>>Bhadradri Kothagudem</option>
                <option value="Hanumakonda" <?php if ($donor['district'] == 'Hanumakonda') echo 'selected'; ?>>Hanumakonda</option>
                <option value="Hyderabad" <?php if ($donor['district'] == 'Hyderabad') echo 'selected'; ?>>Hyderabad</option>
                <option value="Jagtial" <?php if ($donor['district'] == 'Jagtial') echo 'selected'; ?>>Jagtial</option>
                <option value="Jangaon" <?php if ($donor['district'] == 'Jangaon') echo 'selected'; ?>>Jangaon</option>
                <option value="Jayashankar Bhoopalpally" <?php if ($donor['district'] == 'Jayashankar Bhoopalpally') echo 'selected'; ?>>Jayashankar Bhoopalpally</option>
                <option value="Jogulamba Gadwal" <?php if ($donor['district'] == 'Jogulamba Gadwal') echo 'selected'; ?>>Jogulamba Gadwal</option>
                <option value="Kamareddy" <?php if ($donor['district'] == 'Kamareddy') echo 'selected'; ?>>Kamareddy</option>
                <option value="Karimnagar" <?php if ($donor['district'] == 'Karimnagar') echo 'selected'; ?>>Karimnagar</option>
                <option value="Khammam" <?php if ($donor['district'] == 'Khammam') echo 'selected'; ?>>Khammam</option>
                <option value="Kumuram Bheem" <?php if ($donor['district'] == 'Kumuram Bheem') echo 'selected'; ?>>Kumuram Bheem</option>
                <option value="Mahabubabad" <?php if ($donor['district'] == 'Mahabubabad') echo 'selected'; ?>>Mahabubabad</option>
                <option value="Mahabubnagar" <?php if ($donor['district'] == 'Mahabubnagar') echo 'selected'; ?>>Mahabubnagar</option>
                <option value="Mancherial" <?php if ($donor['district'] == 'Mancherial') echo 'selected'; ?>>Mancherial</option>
                <option value="Medak" <?php if ($donor['district'] == 'Medak') echo 'selected'; ?>>Medak</option>
                <option value="Medchal-Malkajgiri" <?php if ($donor['district'] == 'Medchal-Malkajgiri') echo 'selected'; ?>>Medchal-Malkajgiri</option>
                <option value="Mulugu" <?php if ($donor['district'] == 'Mulugu') echo 'selected'; ?>>Mulugu</option>
                <option value="Nagarkurnool" <?php if ($donor['district'] == 'Nagarkurnool') echo 'selected'; ?>>Nagarkurnool</option>
                <option value="Nalgonda" <?php if ($donor['district'] == 'Nalgonda') echo 'selected'; ?>>Nalgonda</option>
                <option value="Narayanpet" <?php if ($donor['district'] == 'Narayanpet') echo 'selected'; ?>>Narayanpet</option>
                <option value="Nirmal" <?php if ($donor['district'] == 'Nirmal') echo 'selected'; ?>>Nirmal</option>
                <option value="Nizamabad" <?php if ($donor['district'] == 'Nizamabad') echo 'selected'; ?>>Nizamabad</option>
                <option value="Peddapalli" <?php if ($donor['district'] == 'Peddapalli') echo 'selected'; ?>>Peddapalli</option>
                <option value="Rajanna Sircilla" <?php if ($donor['district'] == 'Rajanna Sircilla') echo 'selected'; ?>>Rajanna Sircilla</option>
                <option value="Rangareddy" <?php if ($donor['district'] == 'Rangareddy') echo 'selected'; ?>>Rangareddy</option>
                <option value="Sangareddy" <?php if ($donor['district'] == 'Sangareddy') echo 'selected'; ?>>Sangareddy</option>
                <option value="Siddipet" <?php if ($donor['district'] == 'Siddipet') echo 'selected'; ?>>Siddipet</option>
                <option value="Suryapet" <?php if ($donor['district'] == 'Suryapet') echo 'selected'; ?>>Suryapet</option>
                <option value="Vikarabad" <?php if ($donor['district'] == 'Vikarabad') echo 'selected'; ?>>Vikarabad</option>
                <option value="Wanaparthy" <?php if ($donor['district'] == 'Wanaparthy') echo 'selected'; ?>>Wanaparthy</option>
                <option value="Warangal" <?php if ($donor['district'] == 'Warangal') echo 'selected'; ?>>Warangal</option>
                <option value="Yadadri Bhuvanagiri" <?php if ($donor['district'] == 'Yadadri Bhuvanagiri') echo 'selected'; ?>>Yadadri Bhuvanagiri</option>
              </select>
            </div>
            <div class="input-container">
              <label for="dob">Date of Birth:</label>
              <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($donor['dob']); ?>" required onchange="calculateAge()">
            </div>
            <div class="input-container">
              <label for="age">Age:</label>
              <input type="number" id="age" name="age" value="<?php echo htmlspecialchars($donor['age']); ?>" required readonly>
            </div>
            <div class="input-container">
              <label for="gender">Gender:</label>
              <select id="gender" name="gender" required>
                <option value="">Select Gender</option>
                <option value="male" <?php if ($donor['gender'] == 'male') echo 'selected'; ?>>Male</option>
                <option value="female" <?php if ($donor['gender'] == 'female') echo 'selected'; ?>>Female</option>
                <option value="other" <?php if ($donor['gender'] == 'other') echo 'selected'; ?>>Other</option>
              </select>
            </div>
          </div>
        </fieldset>
        <fieldset>
          <legend>2. Contact Information</legend>
          <div class="form-group">
            <div class="input-container">
              <label for="email">Email:</label>
              <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($donor['email']); ?>" required>
            </div>
            <div class="input-container">
              <label for="phone">Phone:</label>
              <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($donor['phone']); ?>" required>
            </div>
            <div class="input-container">
              <label for="password">Password:</label>
              <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($donor['password']); ?>" required>
            </div>
          </div>
        </fieldset>
        <fieldset>
          <legend>3. Health Information</legend>
          <div class="form-group">
            <div class="input-container">
              <label for="weight">Weight (in kg):</label>
              <input type="number" id="weight" name="weight" value="<?php echo htmlspecialchars($donor['weight']); ?>" required>
            </div>
            <div class="input-container">
              <label for="bloodgroup">Blood Group:</label>
              <select id="bloodgroup" name="bloodgroup" required>
                <option value="">Select Blood Group</option>
                <option value="A+" <?php if ($donor['bloodgroup'] == 'A+') echo 'selected'; ?>>A+</option>
                <option value="A-" <?php if ($donor['bloodgroup'] == 'A-') echo 'selected'; ?>>A-</option>
                <option value="B+" <?php if ($donor['bloodgroup'] == 'B+') echo 'selected'; ?>>B+</option>
                <option value="B-" <?php if ($donor['bloodgroup'] == 'B-') echo 'selected'; ?>>B-</option>
                <option value="AB+" <?php if ($donor['bloodgroup'] == 'AB+') echo 'selected'; ?>>AB+</option>
                <option value="AB-" <?php if ($donor['bloodgroup'] == 'AB-') echo 'selected'; ?>>AB-</option>
                <option value="O+" <?php if ($donor['bloodgroup'] == 'O+') echo 'selected'; ?>>O+</option>
                <option value="O-" <?php if ($donor['bloodgroup'] == 'O-') echo 'selected'; ?>>O-</option>
              </select>
            </div>
            <div class="input-container">
              <label for="diseases">Pre-existing Diseases:</label>
              <textarea id="diseases" name="diseases" rows="4" required><?php echo htmlspecialchars($donor['diseases']); ?></textarea>
            </div>
          </div>
        </fieldset>
        <div class="form-group">
          <button type="submit">Update</button>
        </div>
      </form>
      <button onclick="handleLogout()">Logout</button>
    </div>
  </div>
</body>
</html>