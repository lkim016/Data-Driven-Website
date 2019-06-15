@extends('layouts.master')
@section('content')

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

@endsection
