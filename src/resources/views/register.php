<!doctype html>
<html>
    <head>
        <title>Basic User Registration Form</title>
    </head>


    <body>
        <!-- <form action="/user/register" method="post"> -->
            <form action="/user_create" method="post">
            <input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
        
            <table>
                <tr>
                    <td>Username</td>
                    <td><input type="text" name="username"/></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type="text" name="passwd"/></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><input type="text" name="email"/></td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <input type="submit" value="Register"/>
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>
