<!doctype html>
<html>
    <head>
        <title>View All Users</title>
    </head>

    <body>
        <table border="1">
            <tr>
                <td>ID</td>
                <td>Username</td>
                <td>Password</td>
                <td>Email</td>
                <td>Edit</td>
                <td>Delete</td>
            </tr>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->passwd }}</td>
                <td>{{ $user->email }}</td>
                <td><a href='edit/{{ $user->id }}'>Edit</a></td>
                <td><a href='delete/{{ $user->id }}'>Delete</a></td>
            </tr>
            @endforeach
        </table>
        <p><a href="/register"><button type="button">Go to registration page</button></a></p>
        <p><a href="/login"><button type="button">Go to login page</button></a></p>
    </body>
</html>