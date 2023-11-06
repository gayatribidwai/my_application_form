<?php
$servername = "my-db.c43qxldti8jw.us-east-1.rds.amazonaws.com";
$username = "admin";
$password = "admin123";
$dbname = "application_form";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the table already exists
$tableCheckQuery = "SELECT 1 FROM applicants LIMIT 1";
$tableCheckResult = $conn->query($tableCheckQuery);

// If the table doesn't exist, create it
if ($tableCheckResult === false) {
    $tableCreationQuery = "CREATE TABLE applicants (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50) NOT NULL,
        religion VARCHAR(20) NOT NULL,
        category VARCHAR(20) NOT NULL,
        fees DECIMAL(10,2),
        dob DATE NOT NULL
    )";

    if ($conn->query($tableCreationQuery) === false) {
        echo "Error creating table: " . $conn->error;
        $conn->close();
        exit;
    }
}

// Get form data
$name = $_POST['name'];
$religion = $_POST['religion'];
$category = $_POST['category'];
$fees = isset($_POST['fees']) ? $_POST['fees'] : null;
$dob = $_POST['dob'];

// Prepare and execute the SQL query
$sql = "INSERT INTO applicants (name, religion, category, fees, dob) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

$stmt->bind_param("sssss", $name, $religion, $category, $fees, $dob);

$stmt->execute();

// Close the statement
$stmt->close();

// Close the database connection
$conn->close();

// Send the appropriate response back to the client
$age = calculateAge($dob);
if ($age > 30) {
  echo "Sorry, you can't apply.";
} else {
  echo "Form submitted successfully.";
}

function calculateAge($dob) {
  $dobDate = new DateTime($dob);
  $today = new DateTime('2023-06-01');
  $age = $today->diff($dobDate)->y;
  return $age;
}
?>
