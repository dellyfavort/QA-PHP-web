<?php
$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = strtolower($_POST["username"]);
    $password = $_POST["password"];

    // Generate email otomatis
    $email = $username . "@upitra.ac.id";

    $file = "users.json";

    if (file_exists($file)) {
        $users = json_decode(file_get_contents($file), true);
    } else {
        $users = [];
    }

    // Cek username sudah ada
    foreach ($users as $u) {
        if ($u["email"] == $email) {
            $error = "Username sudah digunakan!";
            break;
        }
    }

    if ($error == "") {

        $users[] = [
            "username" => $username,
            "email" => $email,
            "password" => $password
        ];

        file_put_contents($file, json_encode($users));

        $success = "Pendaftaran berhasil! Email kamu: " . $email;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Daftar Member</title>

<style>
body {
    margin:0;
    font-family:Arial;
    background:linear-gradient(135deg,#4facfe,#00f2fe);
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}
.container {
    background:white;
    padding:35px;
    border-radius:15px;
    width:320px;
    text-align:center;
}
input {
    width:100%;
    padding:10px;
    margin:10px 0;
}
button {
    width:100%;
    padding:12px;
    background:#4facfe;
    color:white;
    border:none;
}
.error { color:red; }
.success { color:green; }
</style>
</head>

<body>
<div class="container">

<h2>Daftar Member</h2>

<form method="POST">
    <input type="text" name="username" placeholder="Username / Nama" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Daftar</button>
</form>

<div class="error"><?php echo $error; ?></div>
<div class="success"><?php echo $success; ?></div>

<br>
<a href="login.php">Sudah punya akun? Login</a>

</div>
</body>
</html>
