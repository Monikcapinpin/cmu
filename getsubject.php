<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "student_attendance";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$code = $_GET['code'];


//$sql = "SELECT * FROM windows ORDER BY id DESC LIMIT 0,1";
$sql = "SELECT * FROM subject WHERE code='" . $code . "'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    echo $row["name"];
  }
} else {
  echo "0";
}
$conn->close();
?>