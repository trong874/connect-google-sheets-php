<?php
session_start();
if (isset($_SESSION['auth']['check'])) {
    header('Location: '. '../index.php');
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Login V10</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/util.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/main.css">
</head>
<body>
<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100 p-t-50 p-b-90">
            <form class="login100-form validate-form flex-sb flex-w" method="POST" action="../core/handleLogin.php">
                <span class="login100-form-title p-b-51">Login</span>

                <?php
                if ($_SESSION['err_message'] ?? false) {
                    echo '<span style="color: #c80000;margin-bottom: 8px;">' . $_SESSION['err_message'] . ' <i class="fa fa-exclamation"></i></span>';
                    unset($_SESSION['err_message']);
                }
                ?>

                <div class="wrap-input100 validate-input m-b-16">
                    <input class="input100" type="text" name="username" placeholder="Username" required>
                    <span class="focus-input100"></span>
                </div>
                <div class="wrap-input100 validate-input m-b-16">
                    <span class="btn-show-pass">
                        <i class="fa fa-eye"></i>
                    </span>
                    <input class="input100" type="password" name="password" placeholder="Password" required>
                    <span class="focus-input100"></span>
                </div>
                <div class="flex-sb-m w-full p-t-3 p-b-24">
                    <div class="contact100-form-checkbox">
                        <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
                        <label class="label-checkbox100" for="ckb1">Remember me</label>
                    </div>
                    <div>
                        <a href="#" class="txt1">Forgot?</a>
                    </div>
                </div>
                <div class="container-login100-form-btn m-t-17">
                    <button class="login100-form-btn">Login</button>
                </div>
            </form>
        </div>
    </div>
    <script src="../assets/js/main.js"></script>
</body>
</html>