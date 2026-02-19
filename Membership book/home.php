<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Home Member</title>
</head>
<body>

<h2>Selamat Datang di Membership Buku PDF</h2>

<p>Halo, <?php echo $_SESSION["email"]; ?></p>

<a href="logout.php">Logout</a>

</body>
</html>
