<?php

?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel="stylesheet" href="style.css">

<title>Login</title>
</head>

<body>
    <div class = "intro">
        <h1> Welcome to the CERT Incident Management Tool (CIMT) </h1>
        <h5> The CIMT is an online web application that manages available
        resources and their assignments to various emergency incidents that
        may have already occurred, are happening or may happen in the future
        in and around the campus. Emergency incidents may include, but not limited to,
        hazardous waste spills, acts of terrorism, nuclear incident, campus shooting,
        car crashes with fatalities, flooding, fire, etc. </h5>
    </div>

    <div class = "login">
    <h2>Login</h2>
        <form>
            <div class="form-group">
                <label for="user">Username: </label>
                <input type="text" class="form-control" id="user" aria-describedby="usernameHelp" placeholder="Username">
                <small hidden id="usernameHelp" class="form-text text-muted">Forgot username?</small>
            </div>
            <div class="form-group">
                <label for="password">Password: </label>
                <input type="password" class="form-control" id="password" placeholder="Password">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>

</html>