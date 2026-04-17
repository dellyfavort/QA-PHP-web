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
    
    <!-- Font Awesome untuk Icon Mata -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Link ke CSS eksternal -->
    <link rel="stylesheet" href="style.css">
    
    <!-- CSS untuk Password Toggle -->
    <style>
        .password-wrapper {
            position: relative;
            width: 100%;
            margin-bottom: 0;
        }
        
        .password-wrapper input {
            width: 100%;
            padding: 14px 45px 14px 16px !important;
            margin-bottom: 0;
        }
        
        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #5A6C7D;
            font-size: 16px;
            padding: 5px;
            transition: all 0.2s ease;
            z-index: 1;
        }
        
        .toggle-password:hover {
            color: var(--primary-blue);
        }
        
        .toggle-password:focus {
            outline: none;
            color: var(--dark-blue);
        }
    </style>
</head>

<body>
<div class="container">

    <h2>Login Member</h2>

    <form method="POST">

        <!-- Email -->
        <input type="email" name="email"
               placeholder="Email (@upitra.ac.id)" required
               value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">

        <!-- Password dengan Toggle -->
        <div class="password-wrapper">
            <input type="password" name="password" id="password"
                   placeholder="Password" required>
            <button type="button" class="toggle-password" onclick="togglePassword('password', this)" aria-label="Toggle password visibility">
                <i class="fas fa-eye"></i>
            </button>
        </div>

        <button type="submit">Login</button>

    </form>

    <!-- Error Message -->
    <?php if (!empty($error)): ?>
    <div class="error">
        <?php echo htmlspecialchars($error); ?>
    </div>
    <?php endif; ?>

    <br>
    <a href="daftar.php">Belum punya akun? Daftar</a>
    <br><br>
    <p>
        <a href="reset_password.php">Lupa Password?</a>
    </p>

</div>

<!-- JavaScript untuk Toggle Password -->
<script>
    function togglePassword(inputId, btn) {
        const input = document.getElementById(inputId);
        const icon = btn.querySelector('i');
        const isPassword = input.type === 'password';
        
        // Toggle input type
        input.type = isPassword ? 'text' : 'password';
        
        // Toggle icon (fa-eye <-> fa-eye-slash)
        if (isPassword) {
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>

</body>
</html>