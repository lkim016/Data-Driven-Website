@extends('layouts.master')
@section('content')

    <div class="alert alert-success">
    </div>

    <div class="main-menu">
        <ul>
            <h3>Main Menu</h3>
            <li><a class="nav-link" href="/add-resource">Add Available Resource</a></li>
            <li><a class="nav-link" href="/add-incident">Add Emergency Incident</a></li>
            <li><a class="nav-link" href="/search-resource">Search Resources</a></li>
            <li><a class="nav-link" href="/resource-report">Generate Resource Report</a></li>
        </ul>
    </div>
    
    <hr>
    <footer>
        <span class="exit"></span>
        <a href="/logged-out"><button type="button" class="btn btn-secondary">Exit</button></a>
    </footer>

    <!-- JS -->
    <script type="text/javascript">
        <?php if ( empty($login_val) ) { ?>
            var login_val = 0;
        <?php } else { ?>
            var login_val = JSON.stringify( {!! $login_val !!} );
            login_val = JSON.parse(login_val);
        <?php } ?>
        
        if(login_val === 2) {
            $(".alert").append("<strong>You are now logged in.</strong>");
            $(".alert").show();
        }
    </script>
@endsection