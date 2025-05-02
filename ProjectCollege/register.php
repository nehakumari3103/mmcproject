<?php
include 'db.php';
include 'sidebar';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $phone = mysqli_real_escape_string($conn, $_POST['phone']);
  $course = mysqli_real_escape_string($conn, $_POST['course']);
  $address = mysqli_real_escape_string($conn, $_POST['address']);

  $sql = "INSERT INTO admissions (name, email, phone, course, address)
          VALUES ('$name', '$email', '$phone', '$course', '$address')";

  if (mysqli_query($conn, $sql)) {
    echo "Application submitted successfully!";
  } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }

  mysqli_close($conn);
}
?>