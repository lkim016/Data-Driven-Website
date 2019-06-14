<!doctype html>
<html>
    <head>
        <title>User Management | Edit</title>
    </head>

    <body>
        <form action="/edit/<?php echo $users[0]->id; ?>" method="post">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

            <table>
                <tr>
                    <td>Name</td>
                    <td>
                        <input type='text' name='username' value='<?php echo $users[0]->username; ?>'/>
                        <input type='text' name='passwd' value='<?php echo $users[0]->passwd; ?>'/>
                        <input type='text' name='email' value='<?php echo $users[0]->email; ?>'/>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" value="Update user"/>
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>