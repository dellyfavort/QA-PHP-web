<?php
session_start();
include "db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = strtolower(trim($_POST["email"]));
    $password = $_POST["password"];

    // Validasi domain kampus
    if (!str_ends_with($email, "@upitra.ac.id")) {
        $error = "Gunakan email kampus (@upitra.ac.id)";
    }

    if ($error == "") {

        $query = "SELECT * FROM userlogin WHERE email='$email'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) == 1) {

            $user = mysqli_fetch_assoc($result);

            if (password_verify($password, $user["password"])) {

                $_SESSION["username"] = $user["username"];
                $_SESSION["email"] = $user["email"];

                header("Location: home.php");
                exit;

            } else {
                $error = "Password salah!";
            }

        } else {
            $error = "Email tidak terdaftar!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login Member</title>
<link rel="stylesheet" href="style.css">
</head>

<body>
<div class="container">

<h2>Login Member</h2>

<form method="POST">

    <input type="email" name="email"
           placeholder="Email (@upitra.ac.id)" required>

    <input type="password" name="password"
           placeholder="Password" required>

    <button type="submit">Login</button>

</form>

 <!-- Hanya muncul jika ada error -->
    <?php if (!empty($error)): ?>
    <div class="error">
        <?php echo htmlspecialchars($error); ?>
    </div>
    <?php endif; ?>


<br>

<a href="daftar.php">Belum punya akun? Daftar</a>

<br><br>

<!--  LINK RESET DI DALAM CONTAINER -->
<p>
    <a href="reset_password.php">Lupa Password?</a>
</p>

</div>
</body>
</html>