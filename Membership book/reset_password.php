<?php
include "db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = strtolower(trim($_POST["email"]));
    $newpass = $_POST["password"];

    // Validasi domain kampus
    if (!str_ends_with($email, "@upitra.ac.id")) {
        $message = "Gunakan email kampus!";
    } else {

        // Cek email ada atau tidak
        $cek = mysqli_query($conn,
            "SELECT * FROM userlogin WHERE email='$email'");

        if (mysqli_num_rows($cek) == 1) {

            $hash = password_hash($newpass, PASSWORD_DEFAULT);

            mysqli_query($conn,
                "UPDATE userlogin
                 SET password='$hash'
                 WHERE email='$email'");

            $message = "Password berhasil direset!";
        } else {
            $message = "Email tidak terdaftar!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Reset Password</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

<h2>Lupa Password</h2>

<form method="POST">

    <input type="email" name="email"
           placeholder="Email @upitra.ac.id" required>

    <input type="password" name="password"
           placeholder="Password Baru" required>

    <button type="submit">Reset Password</button>

</form>

<p><?php echo htmlspecialchars($message); ?></p>

<a href="login.php">Kembali ke Login</a>

</div>
</body>
</html>