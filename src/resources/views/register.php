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
                    <td><input type="text" name="username" required/></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type="text" name="passwd" required/></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><input type="text" name="email" required/></td>
                </tr>
                <tr>
                    <!-- <td colspan="2" align="center"> -->
                    <td>
                        <input type="submit" value="Register"/>
                    </td>
                </tr>
                <tr>
                    <td><a href="/view-users"><button type="button">View All Users</button></a></td>
            </table>
        </form>
    </body>
</html>
