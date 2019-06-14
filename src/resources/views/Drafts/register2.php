<?php include('server.php') ?>
<!doctype html>
<html>
    <head>
    <link rel="stylesheet" href="css/style2.css">
        <title>Registration system PHP and MySQL</title>
    </head>

    <body>
        <div class="header">
            <h2>Register</h2>
        </div>

        <form method="post" action="register2.php">
            <?php include('errors.php'); ?>
            <div class="input-group">
                <label>Username</label>
                <input type="text" name="username" value="<?php echo $username; ?>">
            </div>
            <div class="input-group">
                <label>Email</label>
                <input type="email" name="email" value="<?php echo $email; ?>">
            </div>
            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password_1">
            </div>
            <div class="input-group">
                <label>Confirm password</label>
                <input type="password" name="password_2">
            </div>
            <div class="input-group">
                <button type="submit" class="btn" name="reg_user">Register</button>
            </div>
            <p>
                Already a member? <a href="/login2">Sign in</a>
            </p>
        </form>
    </body>
</html>
