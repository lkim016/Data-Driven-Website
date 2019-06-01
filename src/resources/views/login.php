<!doctype html>
<html>
<head>
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>

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
                <input type="text" class="form-control" id="pw1" placeholder="Enter Password" name="password1" required>
                <input type="text" hidden id="pw" name="password"/>
            </div>
            <button type="submit" class="btn btn-primary" id="login_submit">Submit</button>
            <!--<a href="/main" class="btn btn-primary">Submit</a><br/><br/> -->
            <label>
                <input type="checkbox" checked="checked" name="remember">Remember me
            </label><br/>
            <p><span class="pw">Forgot <a href="#">password?</a></span></p>
            <p><span class="reg">Click here to <a href="/register">register.</a></span></p>
        </form>
    </div>

    <script type = "text/javascript">
        var store_inp = '';
        // problem: a space is added / solution: need to catch the special keys 
        $("#pw1").on( "keydown", function () { // change to "keyup"
            if (event.which == 8) {
                store_inp = store_inp.substr(0, store_inp.length - 1)
            } else {
                store_inp += String.fromCharCode(event.which);
            }
            convert_str( $(this) );
            console.log( store_inp );
        });

        $("#login_submit").on("click", function () {
            $("#pw").val ( store_inp );
        });

        function convert_str (this_obj) {
            // store user input to pass to db
            $(this_obj).val( $(this_obj).val().replace( this_obj.val(), rep(this_obj.val()) ) );
            
            function rep(val_obj) {
                var len = val_obj.length;
                var result = '';
                for (i = 0; i < len ; i++) {
                    result += '*';
                }
                return result;
            }
        };

    </script>

</body>
</html>


