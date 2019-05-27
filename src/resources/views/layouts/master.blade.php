<!doctype html>
<html>
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel="stylesheet" href="css/style.css">

<title>Main</title>
</head>

<body>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <ul class="nav navbar-nav">
            <li class="active"><a class="nav-link" href="/add-resource">Add Available Resource</a></li>
            <li class="nav-item"><a class="nav-link" href="/add-incident">Add Emergency Incident</a></li>
            <li class="nav-item"><a class="nav-link" href="/search-resource">Search Resources</a></li>
            <li class="nav-item"><a class="nav-link" href="/resource-report">Generate Resource Report</a></li>
        </ul>
    </nav>

    <div class="row">
        <div class="col-sm left">
            <h2>{{ session('login_disp') }}</h2> <!-- pick up here -->
        </div>
        <div class="col-sm right">
            <h5>{{ session('user') }}</h5>
            <!-- user specific info -->
            @if ( session('login_email') <> 0 )
                <h5>{{ session('login_email') }}</h5>
            @elseif ( session('login_phone') <> 0)
                <h5>{{ session('login_phone') }}</h5>
            @elseif ( sesson('login_add') <> 0)
                <h5>{{ session('login_add') }}</h5>
            @endif
        </div>
    </div>

    <div>
    @yield('content')
    </div>

</body>
</html>