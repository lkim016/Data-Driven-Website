<!doctype html>
<html>
<head>
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<style>

</style>

<title>Login</title>
</head>

<body>
    <div class = "header">
        <h1 align="center"><b>Welcome to the CERT Incident Management Tool (CIMT)</b></h1><br/>
        <p align="center">The CIMT is an online web application that manages available resources and their
        assignments to various emergency incidents that may have already occured, are happening or may happen in
        the future in and around the campus. Emergency incidents may include, but not limited to, hazardous waste
        spills, acts of terrorism, nuclear incident, campus shooting, car crashes with fatalities,
        flooding, fire, etc.</p>
    </div>

    <div id="id01" class="login">
    <h1>Login</h1>
        <form method = "post" action = "/main">
            <input type = "hidden" name = "_token" value = "<?php echo csrf_token() ?>">
            <div class="form-group">
                <label for="user">Username:</label>
                <input type="text" class="form-control" id="user" placeholder="Enter Username" name="username" required>
            </div>
            <div class="form-group">
                <label for="pw">Password: </label>
                <input type="text" class="form-control" id="pw" placeholder="Enter Password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <!--<a href="/main" class="btn btn-primary">Submit</a><br/><br/> -->
            <label>
                <input type="checkbox" checked="checked" name="remember">Remember me
            </label><br/>
            <p><span class="pw">Forgot <a href="#">password?</a></span></p>
            <p><span class="reg">Click here to <a href="/register">register.</a></span></p>
        </form>
    </div>

</body>
</html>


