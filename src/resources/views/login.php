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
        var store_user_inp = '';
        // problem: a space is added / solution: need to catch the special keys
        // store_user_inp exceptions: backspace on hold, selection: replacing all or up to selection, copy and paste
        $("#pw1").on('keydown keyup', function(event) {
            var this_obj = this;
            input_key_check(this_obj, event, event.type)
        });

        $("#login_submit").on("click", function () {
            $("#pw").val ( store_user_inp );
        });

        function convert_pw (self) {
            // change this val to the length of store_user_inp
            $(self).val( rep() );
            
            function rep() { // inner function to return the value of #pw1
                var len = store_user_inp.length;
                var result = '';
                for (i = 0; i < len ; i++) {
                    result += '*';
                }
                return result;
            }

        };

        function input_key_check(obj, e, t_type) {
            var extra_keycode = [8, 37, 38, 39, 40, 186, 187, 189, 191, 222]; // special char keycode
            var key_array = allowed_keycode(extra_keycode);
            var key = '';
            var pass_obj = obj; // pw1 object
            
            for (i=0; i<key_array.length; i++) {
                if (e.which === key_array[i]) {
                    key = e.which;
                    break;
                } else if (e.ctrlKey || e.altKey) {
                    break;
                }
            };
            // checks trigger and assigns proper event
            if (key !== '') {
                switch(t_type) {
                    case 'keydown':
                        // Would want to convert this on keydown, but I would have to store the value and then check if the keycode matches
                        store_input(key);
                        break;
                    case 'keyup':
                        if (key !== 8) {
                            convert_pw(pass_obj);
                        }
                        break;
                }
            }
            // PROBLEM: NEED TO WORK ON WHEN I SELECT AND TYPE
            console.log(store_user_inp);
        }

        function store_input(key_code) {
            // if trig = 'keypress' then only have to do backspace
            if (key_code === 8) {
                store_user_inp = store_user_inp.substr(0, store_user_inp.length - 1);
            } else if(key_code !== 16) {
                store_user_inp += String.fromCharCode(key_code);
            }
        }

        function allowed_keycode(extra_char) {
            // backspace: 8
            // shift, caps: 16, 20
            // arrows: 37-40
            // special chars: 186, 187, etc...
            var pass_code = [];
            var extra = extra_char;
            var code_len = (90-48) + extra.length;
            var a_to_num = 48; // keyboard numbers-alpha: 48-90
            var extra_iter = 0;
            for (i = 0; i < code_len; i++) {
                if (a_to_num < 91) { // inputting character key for alpha-num
                    pass_code[i] = a_to_num;
                    a_to_num += 1;
                } else { // adding any other keys that are allowed
                    pass_code[i] = extra[extra_iter];
                    extra_iter += 1;
                }
            }
            return pass_code;
        }

    </script>

</body>
</html>



