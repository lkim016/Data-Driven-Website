<!doctype html>
<html>
    <head>
        <title>User Registration | Add</title>
    </head>

    <body>
        <form action="/create" method="post">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <table>
                <tr>
                    <td>Name</td>
                    <td><input type="text" name="username"/></td>
                </tr>
                <tr>
                    <td colspan='2'>
                        <input type="submit" value="Add user"/>
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>