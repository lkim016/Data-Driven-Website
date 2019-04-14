<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel="stylesheet" href="style.css">

<title>Main</title>
</head>

<body>
   <!-- A vertical navbar -->
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <!-- Links -->
        <ul class="nav navbar-nav">
            <li class="active">
                <a class="nav-link" href="#">Add Available Resource</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Add Emergency Incident</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Search Resources</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Generate Resource Report</a>
            </li>
        </ul>
    </nav>

        <div class="row">
            <div class="col-sm left">
                <h2>[ USER TYPE ]</h2>
            </div>
            <div class="col-sm right">
                <h5> [ USERNAME ] </h5>
                <h5> [ USER SPECIFIC INFO ] </h5>
            </div>
        </div>

    <hr>

    <div class = "main-menu">
        <ul>
            <h3>Main Menu</h3>
            <li>
                <a class="nav-link" href="#">Add Available Resource</a>
            </li>
            <li>
                <a class="nav-link" href="#">Add Emergency Incident</a>
            </li>
            <li>
                <a class="nav-link" href="#">Search Resources</a>
            </li>
            <li>
                <a class="nav-link" href="#">Generate Resource Report</a>
            </li>
        </ul>
    </div>

    <span class = "exit"></span>
    <a href="login.php"><button type="button" class="btn btn-secondary">Exit</button></a>
</body>

</html>