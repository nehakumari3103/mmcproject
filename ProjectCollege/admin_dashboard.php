<?php
session_start();

// Simple login check
$valid_user = "admin";
$valid_pass = "12345";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user = $_POST["username"];
    $pass = $_POST["password"];
    if ($user === $valid_user && $pass === $valid_pass) {
        $_SESSION["admin"] = true;
    } else {
        echo "<h3>Invalid credentials</h3>";
        exit;
    }
} elseif (!isset($_SESSION["admin"])) {
    echo "<h3>Please log in from <a href='login.html'>login.html</a></h3>";
    exit;
}

include '../php/db.php';

// Fetch data
$admissions = mysqli_query($conn, "SELECT * FROM admissions ORDER BY applied_at DESC");
$messages = mysqli_query($conn, "SELECT * FROM contact_messages ORDER BY submitted_at DESC");
$events = mysqli_query($conn, "SELECT * FROM events ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<section class="admin-section">
  <h2>Admin Dashboard</h2>
  <a href="?logout=true" style="float:right; color:red;">Logout</a>

  <h3>Admission Applications</h3>
  <table>
    <tr><th>Name</th><th>Email</th><th>Phone</th><th>Course</th><th>Applied At</th></tr>
    <?php while ($row = mysqli_fetch_assoc($admissions)) { ?>
      <tr>
        <td><?= $row["name"] ?></td>
        <td><?= $row["email"] ?></td>
        <td><?= $row["phone"] ?></td>
        <td><?= $row["course"] ?></td>
        <td><?= $row["applied_at"] ?></td>
      </tr>
    <?php } ?>
  </table>

  <h3>Contact Messages</h3>
  <table>
    <tr><th>Name</th><th>Email</th><th>Subject</th><th>Message</th><th>Submitted At</th></tr>
    <?php while ($row = mysqli_fetch_assoc($messages)) { ?>
      <tr>
        <td><?= $row["name"] ?></td>
        <td><?= $row["email"] ?></td>
        <td><?= $row["subject"] ?></td>
        <td><?= $row["message"] ?></td>
        <td><?= $row["submitted_at"] ?></td>
      </tr>
    <?php } ?>
  </table>

  <h3>Add New Event</h3>
  <form action="upload_event.php" method="POST">
    <input type="text" name="date" placeholder="Month Year (e.g. April 2025)" required />
    <input type="text" name="title" placeholder="Event Title" required />
    <textarea name="description" placeholder="Event Description" required></textarea>
    <button type="submit">Add Event</button>
  </form>

  <h3>Upload Gallery Image</h3>
  <form action="upload_gallery.php" method="POST" enctype="multipart/form-data">
    <input type="file" name="image" accept="image/*" required />
    <button type="submit">Upload</button>
  </form>

  <h3>Existing Events</h3>
  <ul>
    <?php while ($event = mysqli_fetch_assoc($events)) { ?>
      <li><strong><?= $event["date"] ?> - <?= $event["title"] ?></strong><br><?= $event["description"] ?></li>
    <?php } ?>
  </ul>
</section>

</body>
</html>

<?php
if (isset($_GET["logout"])) {
  session_destroy();
  header("Location: admin_login.html");
  exit;
}
?>