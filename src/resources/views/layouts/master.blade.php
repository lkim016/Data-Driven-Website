<!doctype html>
<html>
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel="stylesheet" href="css/style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<!-- datepicker -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

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

    <div class="row";>
        <div class="col-sm left">
            <h2>{{ session('user_type') }}</h2> <!-- pick up here -->
        </div>
        <div class="col-sm right">
            <h5>{!! session('login_disp') !!}</h5> <!-- want to have user name and add a drop down under with info and log out -->
            <!-- user specific info -->
            @if ( session('login_email') <> 0 )
                <h5>{{ session('login_email') }}</h5>
            @elseif ( session('login_phone') <> 0)
                <h5>{{ session('login_phone') }}</h5>
            @elseif ( session('login_add') <> 0)
                <h5>{{ session('login_add') }}</h5>
            @endif
        </div>
    </div>

    <div>
    @yield('content')
    </div>

</body>
</html>