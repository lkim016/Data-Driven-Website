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
                <td>Email</td>
                <td>Edit</td>
                <td>Delete</td>
            </tr>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->email }}</td>
                <td><a href='edit/{{ $user->id }}'>Edit</a></td>
                <td><a href='delete/{{ $user->id }}'>Delete</a></td>
            </tr>
            @endforeach
        </table>
    </body>
</html>