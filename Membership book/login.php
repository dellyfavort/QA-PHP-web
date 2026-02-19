<?php
session_start();

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"];
    $password = $_POST["password"];

    if (!str_ends_with($email, "@upitra.ac.id")) {
        $error = "Gunakan email @upitra.ac.id";
    } else {

        if (!file_exists("users.json")) {
            $error = "Belum ada akun terdaftar";
        } else {

            $users = json_decode(file_get_contents("users.json"), true);
            $valid = false;

            foreach ($users as $u) {
                if ($u["email"] == $email && $u["password"] == $password) {
                    $valid = true;
                    break;
                }
            }

            if ($valid) {
                $_SESSION["login"] = true;
                $_SESSION["email"] = $email;

                header("Location: home.php");
                exit;
            } else {
                $error = "Email atau password salah";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login Member</title>

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
</style>
</head>

<body>
<div class="container">

<h2>Login Member</h2>

<form method="POST">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form>

<div class="error"><?php echo $error; ?></div>

<br>
<a href="daftar.php">Belum punya akun? Daftar</a>

</div>
</body>
</html>
