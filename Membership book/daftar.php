<?php
include "db.php";

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = strtolower(trim($_POST["username"]));
    $password = $_POST["password"];

    // Generate email otomatis
    $email = $username . "@upitra.ac.id";

    // =========================
    // VALIDASI PASSWORD KUAT
    // =========================
    if (strlen($password) < 8) {
        $error = "Password minimal 8 karakter";
    }
    elseif (!preg_match("/[A-Z]/", $password)) {
        $error = "Harus ada huruf besar";
    }
    elseif (!preg_match("/[a-z]/", $password)) {
        $error = "Harus ada huruf kecil";
    }
    elseif (!preg_match("/[0-9]/", $password)) {
        $error = "Harus ada angka";
    }
    elseif (!preg_match("/[\W]/", $password)) {
        $error = "Harus ada simbol";
    }

    // =========================
    // CEK USER SUDAH ADA
    // =========================
    if ($error == "") {

        $cek = mysqli_query($conn,
            "SELECT * FROM userlogin WHERE email='$email'");

        if (mysqli_num_rows($cek) > 0) {
            $error = "Username sudah digunakan!";
        }
    }

    // =========================
    // SIMPAN KE DATABASE
    // =========================
    if ($error == "") {

        // Hash password (disarankan)
        $hashPassword = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO userlogin (username, email, password)
                  VALUES ('$username', '$email', '$hashPassword')";

        if (mysqli_query($conn, $query)) {
            $success = "Pendaftaran berhasil! Email kamu: $email";
        } else {
            $error = "Gagal menyimpan data!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Daftar Member</title>
<link rel="stylesheet" href="style.css">
</head>

<body>
<div class="container">

<h2>Daftar Member</h2>

<form method="POST">

    <input type="text" name="username"
           placeholder="Username / Nama" required>

    <input type="password" name="password"
           placeholder="Password" required>

    <small>
        Minimal 8 karakter, huruf besar, kecil, angka, simbol
    </small>

    <button type="submit">Daftar</button>

</form>

<!-- ✅ ERROR - Hanya muncul jika ada error -->
    <?php if (!empty($error)): ?>
    <div class="error">
        <?php echo htmlspecialchars($error); ?>
    </div>
    <?php endif; ?>

    <!-- ✅ SUCCESS - Hanya muncul jika sukses -->
    <?php if (!empty($success)): ?>
    <div class="success">
        <?php echo htmlspecialchars($success); ?>
    </div>
    <?php endif; ?>

<br>

<a href="login.php">Sudah punya akun? Login</a>

<br><br>

<!--  LINK RESET (DI DALAM CONTAINER) -->
<p>
    <a href="reset_password.php">Lupa Password?</a>
</p>

</div>
</body>
</html>