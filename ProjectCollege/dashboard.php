if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user = $_POST["username"];
    $pass = $_POST["password"];
    
    $result = mysqli_query($conn, "SELECT * FROM admins WHERE username='$user'");
    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($pass, $row["password"])) {
            $_SESSION["admin"] = true;
        } else {
            echo "<h3>Incorrect password</h3>";
            exit;
        }
    } else {
        echo "<h3>Admin not found</h3>";
        exit;
    }
}